<?php

    namespace mvc\controllers;

    use mvc\controllers\CartController;                    
    use src\support\CalculateShip;
    use src\support\Session;
    use mvc\models\ProductsModel;
    use mvc\models\CategoryFieldsModel;
    use mvc\models\ClientsModel;
    use mvc\models\AddressClientModel;
    use mvc\models\AddressModel;
    use mvc\models\AdminsModel;

    class AjaxController extends Controller {

        public function findZip() { 
            
            $zip = filter_input(INPUT_POST,"zip");

            $url = "https://viacep.com.br/ws/" . onlyNumbers($zip) . "/json";
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
        
            $result = curl_exec($ch);
            
            $base = json_decode($result);
        
            if (!isset($base->erro) && !isset($base->cep)){        
                $address = "erro_inter";  
            } else {
                if (isset($base->erro)) {        
                    $address = "erro_cep";  
                } else {
                    
                    Session::set("address", [
                        "zip" => onlyNumbers($base->cep),
                        "address" => $base->logradouro,
                        'number' => '',
                        "complement" => $base->complemento,
                        "neighborhood" => $base->bairro,
                        "city" => $base->localidade,
                        "state" => $base->uf,
                    ]);
        
                    $address = Session::get("address");  
                }
            }

            echo json_encode($address);
            
        }

        public function calculateShip(CalculateShip $calculateShip, CartController $cartController) {

            $calculateShip = new CalculateShip;

            $calculateShip->execute();

            $js = "<script>$('div.chekout').css('display', 'flex');</script>";
            
            return loadTemplate("/ajax/cart/calculateShip", [
                                                              "js"=>$js,
                                                              "response" => [
                                                                "totalCart"=>$cartController->total(), 
                                                                "shipValue"=>Session::get("shipValue"),
                                                                "valueFinal" => $cartController->total() + Session::get("shipValue")
                                                              ]
                                                            ], "ajax");

        }

        public function addCart(CartController $cartController, ProductsModel $productsModel) {

            $id = filter_input(INPUT_POST,"id", FILTER_VALIDATE_INT);
            
            $cartController->add($id);
        
            $cart = $cartController->get("cart");
            $product =  $productsModel->find($id);
            
            $productCart = [
                "quantity" => $cart[$id]["quantity"],
                "totalPrice" => $cart[$id]["quantity"] * $product["precoUnitario"],
                "cartTotal" => $cartController->total()
            ];
        
            echo json_encode($productCart);

        }

        public function subCart(CartController $cartController, ProductsModel $productsModel) {

            $id = filter_input(INPUT_POST,"id", FILTER_VALIDATE_INT);
            
            $cartController->sub($id);
        
            $cart = $cartController->get("cart");
            $product =  $productsModel->find($id);

            $shipTotal = Session::has("shipValue")
                            ? Session::get("shipValue")
                            : "";
            
            $productCart = [
                "quantity" => $cart[$id]["quantity"],
                "totalPrice" => $cart[$id]["quantity"] * $product["precoUnitario"],
                "cartTotal" => $cartController->total()
            ];     
            
            echo json_encode($productCart);

        }

        public function sendCart(CartController $cartController, ProductsModel $productsModel) {    
            
            $id = filter_input(INPUT_POST,"id", FILTER_VALIDATE_INT);
    
            $cartController->add($id);
        
            $cart = $cartController->get("cart");
            $product =  $productsModel->find($id);
            
            $productCart = [
                "quantity" => $cart[$id]["quantity"],
                "totalPrice" => $cart[$id]["quantity"] * $product["precoUnitario"],
                "cartTotal" => $cartController->total(),
                "totalItemsCart" => $cartController->count()
            ];        

            echo json_encode($productCart);

        }     

        public function excludeCart(CartController $cartController) {    

            $id = filter_input(INPUT_POST,"id", FILTER_VALIDATE_INT);
        
            $cartController->dropItem($id);
            
            $total = $cartController->total();
            $count = $cartController->count();

            $shipTotal = Session::has("shipValue")
                            ? Session::get("shipValue")
                            : "";
        
            $productCart = [
                "cartTotal" => $total,
                "cartCount" => $count,
                "redirect" => route("shopping.cart"),
                "shipTotal" => $shipTotal
            ];    

            echo json_encode($productCart);

        }

        public function choiceCategory(CategoryFieldsModel $categoryFieldsModel) {    

            $category = filter_input(INPUT_POST,"category");
            
            $fields = $categoryFieldsModel->findFields($category); 

            echo json_encode($fields);
            
        }     

        public function deleteAddressClient(AddressClientModel $addressClientModel, AddressModel $addressModel) {    

            $address = filter_input(INPUT_POST,"address");
            $client = Session::get("sessionClient")["id"];
            
            $addressClientModel->deleteAddressClient($client, $address);

            echo json_encode("");

        }    

        public function addressComplete(AddressClientModel $addressClientModel, AddressModel $addressModel) {    

            $number = filter_input(INPUT_POST,"number");
            $complement = filter_input(INPUT_POST,"complement");

            Session::alterSession("address", [
                "number" => $number,
                "complement" => $complement
            ]);

            $this->saveAddress(Session::get("address"));

        }    


        public function saveAddressFields()  {
            
            $zip = filter_input(INPUT_POST,"zip", FILTER_VALIDATE_INT);
            $addressForm = filter_input(INPUT_POST,"address", FILTER_SANITIZE_STRIPPED); 
            $number = filter_input(INPUT_POST,"number", FILTER_SANITIZE_STRIPPED); 
            $complement = filter_input(INPUT_POST,"complement", FILTER_SANITIZE_STRIPPED); 
            $neighborhood = filter_input(INPUT_POST,"neighborhood", FILTER_SANITIZE_STRIPPED); 
            $city = filter_input(INPUT_POST,"city", FILTER_SANITIZE_STRIPPED); 
            $state = filter_input(INPUT_POST,"state", FILTER_SANITIZE_STRIPPED); 

            $address = [
                "zip" => $zip,
                "address" => $addressForm,
                "number" => $number,
                "complement" => $complement,
                "neighborhood" => $neighborhood,
                "city" => $city,
                "state" => $state,
            ];

            $this->saveAddress($address);
            
        }     
        
        public function saveAddress(array $address) {
            
            $client = Session::get("sessionClient");

            $addressClientModel = new AddressClientModel;
            $addressModel = new AddressModel;
            
            $findAddress = $addressModel->findAddress($address);

            if(is_null($findAddress)){
                $addressModel->store($address);
                $addressID = $addressModel->lastInsertId();
            } else {
                $addressID = $findAddress["id"];
            }
    
            $findAddressClient = $addressClientModel->findAddressClient($client["id"], $addressID);

            if(!($findAddressClient)){     

                $addressClient = [
                    "client" => ($client["id"]),
                    "address" => $addressID
                ];
    
                echo $addressClientModel->store($addressClient)
                        ? json_encode("ok")
                        : json_encode("Erro de interoperação");
            } else {
               echo  json_encode("Endereço já cadastrado");
            }   
            
        }        
    
        /* Esse método bloqueia o cliente de um determinado id */
        
        public function bloqClient (int $id, ClientsModel $clientsModel) {       

            if (!$id) {
                error("Campo ID não enviado");  
                return redirectToRoute(route("admin.clients.listAll"));
            }

            $client = $clientsModel->find($id);
            
            $bloq = $client["bloq"] === "Sim"
                            ? "Não"
                            : "Sim";                           

            $clientsModel->bloq($id, $bloq);   
            
            $client = $clientsModel->find($id);
            
            echo json_encode($client["bloq"]);
            
        }        
    
        /* Esse método bloqueia o administrador de um determinado id */
        
        public function bloqAdmin (int $id, AdminsModel $adminsModel) {       

            if (!$id) {
                error("Campo ID não enviado");  
                return redirectToRoute(route("admins.listAll"));
            }

            $admin = $adminsModel->find($id);
            
            $bloq = $admin["bloq"] === "Sim"
                            ? "Não"
                            : "Sim";                           

            $adminsModel->bloq($id, $bloq);   
            
            $admin = $adminsModel->find($id);
            
            echo json_encode($admin["bloq"]);
            
        }   
    
        /* Esse método bloqueia o cliente de um determinado id */
        
        public function bloqProduct (int $id, ProductsModel $productsModel) {       

            if (!$id) {
                error("Campo ID não enviado");  
                return redirectToRoute(route("products.listAll"));
            }

            $product = $productsModel->find($id);
            
            $bloq = $product["bloq"] === "Sim"
                            ? "Não"
                            : "Sim";                           

            $productsModel->bloq($id, $bloq);   
            
            $product = $productsModel->find($id);
            
            echo json_encode($product["bloq"]);
            
        }

    }