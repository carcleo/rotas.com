<?php

    namespace mvc\controllers;

    use mvc\models\AdminsModel;
    use src\router\Request;
    use src\router\Route;
    use src\support\Session;

    class AdminsController extends Controller {

        private $adminsModel;

        /*construtor da classe */
        public function __construct(AdminsModel $adminsModel)  {
            $this->adminsModel = $adminsModel ;
        }        

        public function login()  {
            if(Session::has("admin")) {
                return redirectToRoute(route("admin.home"));
            }
            return loadTemplate("site/adminLogin");
        }

        public function logon()  {                 
 
            $crypt = filter_input(INPUT_POST,"crypt", FILTER_SANITIZE_STRIPPED); 
            $login = filter_input(INPUT_POST,"login", FILTER_SANITIZE_STRIPPED);
            $password = filter_input(INPUT_POST,"password", FILTER_SANITIZE_STRIPPED);

            if (!$crypt || empty($crypt) || $crypt !==  hash512()) {
                
                error("Houve um erro geral, favor contatar o(utro) administrador do site e informe o erro: crypt");
                return redirectToRoute(route("admin.login"));

            }  

            $formFields = [
                "crypt" => $crypt,
                "login" => $login,
                "password" => $password
            ];
            
            foreach ($formFields as $field) {  
                if (!$field) {
                    error("Algum campo preenchido incorretamente");
                    return redirectToRoute(route("admin.login"));
                }
            }           

            $admin = $this->adminsModel->findAdminLogin($login, $password);

            if (is_null($admin)) {                                   
                error("Logon incorreto, tente novamente");
                return redirectToRoute(route("admin.login"));
            }
            
            if ($admin["bloq"] === "Sim"){    
                error("Administrador bloqueado, contate um Super Administrador");
                return redirectToRoute(route("admin.login"));
            }
            
            Session::set("sessionAdmin", $admin);

            return redirectToRoute(route("admin.home"));

        }
        /*carrega o formulário para cadastro de um novo admin */
		public function logout () {  
            if ( Session::has("sessionAdmin") ){
                Session::unSet("sessionAdmin");
            }

            return redirectToRoute(route("admin.login"));
            
		}
        
        
        /*Carrega a página da Administraçãp */
		public function home (Request $request) {  
            return loadTemplate("admin/admin", null, "admin");
		}
        
        
        /*carrega o formulário para cadastro de um novo admin */
		public function create (Request $request) {  
            return loadTemplate("admin/adminCreate", null, "admin");
		}
        
        /*Lista todos os admins cadastrados */
        public function listAll () {
            $admins = $this->adminsModel->selectAll();
            $js= "<script src='" . assets('js/bloq.js') . "'></script>";
            return loadTemplate("admin/adminsListAll", ["js"=>$js,"admins"=> $admins], "admin");
        }
        
        private function formFields () :array {            
            
            $privilege = filter_input(INPUT_POST,"privilege", FILTER_SANITIZE_STRIPPED); 
            $name = filter_input(INPUT_POST,"name", FILTER_SANITIZE_STRIPPED);
            $login = filter_input(INPUT_POST,"login", FILTER_SANITIZE_STRIPPED);
            $password = filter_input(INPUT_POST,"password", FILTER_SANITIZE_STRIPPED);
            $bloq = filter_input(INPUT_POST,"bloq", FILTER_SANITIZE_STRIPPED);        
            $crypt = filter_input(INPUT_POST,"crypt", FILTER_SANITIZE_STRIPPED); 
            $datetime = filter_input(INPUT_POST,"datetime", FILTER_SANITIZE_STRIPPED);     

            return [
                "crypt" => $crypt,
                "privilege" => $privilege,
                "name" => $name,
                "login" => $login,
                "password" => $password,
                "bloq" => $bloq,
                "datetime" => $datetime
            ];
        }

        private function validateFields() :bool {   

            $fields = $this->formFields();
            
            foreach ($fields as $field) {  
                if (!$field) {
                   return false;
                }
            }

            return true;

        }
        
        private function adminValidate(string $redirect) :bool {   

            if (!$this->validateFields()) {
                error("Algum campo preenchido incorretamente");
                return redirectToRoute($redirect);      

            }             

            $fields = $this->formFields();

            $crypt = $fields["crypt"];

            if (!$crypt || empty($crypt) || $crypt !==  hash512()) {
                error("Houve um erro geral, favor contatar o administrador do site e informe o erro: crypt");
                return redirectToRoute($redirect);                

            }  

            return true;

        }

        private function missingFields () {

            $fields = $this->formFields();
            $missingFields = NULL;

            foreach ($fields as $key => $value) {  
                if ($key !== "login" && $key !== "crypt") {
                    if ($value === "") {
                        $missingFields[] = $key;
                    }
                }
            }

            return $missingFields;

        }

        /*grava um admin na base de dados */
        public function store(Request $request)  {

            $this->adminValidate(route("admin.create"));

            $missingFields = $this->missingFields();

            if ( !is_null( $missingFields ) ) {

                $missingFields = implode (",", $missingFields);
                $missingFields = substr($missingFields, 0, -1);
                error("O(s) campo(s) " . $missingFields . " precisam de atenção");
                return redirectToRoute(route("admin.create"));

            }

            $formFields = $this->formFields();
            $formFields =  array_splice($formFields, 1);

            $findAdmin = $this->adminsModel->findAdmin($formFields["name"]);
            $findLogin = $this->adminsModel->findLogin($formFields["login"]);

            if ($findAdmin) {
                
                error("Administrador já cadastrado. Pesquise!");

                return redirectToRoute(route("admin.create"));

            }

            if ($findLogin) {

                error("Esse login já está sendo usado. Escolha outro!");

                return redirectToRoute(route("admin.create"));

            }

            $admin = $this->adminsModel->store($formFields);
            
            if(!$admin) {
                error("Erro no processo do cadastro");

                return redirectToRoute(route("admin.create"));
            }

            success("Cadastro efetuado com sucesso!");

            $id = $this->adminsModel->lastInsertId();

            return redirectToRoute(route("admin.edit",[$id]));

        }

        /*carrega o formulário para edição de um admin */
		public function edit (int $id) {
            
            $admin = $this->adminsModel->find($id);
            
            if ( is_null($admin) ) {

                return redirectToRoute(route("error.404"));

            }             
                            
            return loadTemplate("admin/adminEdit", ["admin"=>$admin, "privilege"=>Session::get("sessionAdmin")["privilege"]], "admin");
                
		}

		/*grava a edição de um admin */
        public function update() {           
            
            $id = filter_input(INPUT_POST,"id", FILTER_VALIDATE_INT);

            if (!$id) {

                error("Campo ID não enviado. Contate o administrador do site");
                return redirectToRoute(route("admins.listAll"));

            } 

            $this->adminValidate(route("admin.edit",[$id])); 

            $missingFields = $this->missingFields();

            if ( !is_null( $missingFields ) ) {

                $missingFields = implode (",", $missingFields);
                $missingFields = substr($missingFields, 0, -1);
                error("O(s) campo(s) " . $missingFields . " precisam de atenção");
                return redirectToRoute(route("admin.edit",[$id]));

            }
        
            $formFields = $this->formFields();
            $formFields =  array_splice($formFields, 1);

            $findAdmin = $this->adminsModel->findAdmin($formFields["name"]);
            $findLogin = $this->adminsModel->findLogin($formFields["login"]);
            
            if ($findAdmin === true && $formFields["name"] !== $_POST["oldName"]) {
                
                error("Administradr já cadastrado. Pesquise!");

                return redirectToRoute(route("admin.edit",[$id]));

            }

            if ($findLogin === true && $formFields["login"] !== $_POST["oldLogin"]) {
                
                error("Esse login já está sendo usado. Escolha outro!");

                return redirectToRoute(route("admin.edit",[$id]));

            }

            $admin = $this->adminsModel->update($formFields, $id);     
            
            if(!$admin) {
                error("Erro no processo do cadastro");
                return redirectToRoute(route("admin.edit",[$id]));
            }

            success("Alteração efetuada com sucesso!");

            return redirectToRoute(route("admin.edit",[$id]));

        }
		
		/* Esse método exclui um registro com um determinado id */
		
		public function delete (Request $request) {       
            
            $id = filter_input(INPUT_POST,"id", FILTER_VALIDATE_INT);

            if (!$id) {
                error("Campo ID não enviado");
                return redirectToRoute(route("admins.listAll"));
            }

            $this->adminsModel->delete($id);

            return redirectToRoute(route("admins.listAll"));
            
        }
		

    }