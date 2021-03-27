<?php

    namespace mvc\controllers;

    use mvc\models\ContactsModel;
    use src\router\Request;
    use src\support\Session;

class ContactsController extends Controller {

        private $contactsModel;

        /*construtor da classe */
        public function __construct()  {
            $this->contactsModel = new ContactsModel;
        }
        
        /*carrega o formulário para cadastro de um novo contato */
		public function create (Request $request) {
            $addressSite = $request->address();  
            $tel = $request->tel();
            $js = "<script src='" . assets("js/jquery.mask.js") . "'></script>
                   <script src='" . assets("js/masks.js") . "'></script>";
            return loadTemplate("site/contactCreate",["addressSite"=>$addressSite, "tel"=>$tel, "js"=>$js]);
		}
        
        /*Lista todos os contatos cadastrados */
        public function listAll () {
            $contacts = $this->contactsModel->selectAll();
            return loadTemplate("admin/contactListAll", ["contacts"=> $contacts], "admin");
        }
        
        /*validando o campo E-mail */
		public function emailValidate (string $email) :bool {
            $regex = "^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$";
            return preg_match($regex, $email)
                         ? true
                         : false;                         
        }
        
        private function formFields () :array {            
            
            $name = filter_input(INPUT_POST,"name", FILTER_SANITIZE_STRIPPED);
            $tel = filter_input(INPUT_POST,"tel", FILTER_SANITIZE_STRIPPED);
            $email = filter_input(INPUT_POST,"email", FILTER_VALIDATE_EMAIL);
            $subject = filter_input(INPUT_POST,"subject", FILTER_SANITIZE_STRIPPED);     
            $message = filter_input(INPUT_POST,"message", FILTER_SANITIZE_STRIPPED); 
            $datetime = filter_input(INPUT_POST,"datetime", FILTER_SANITIZE_STRIPPED);      
            $crypt = filter_input(INPUT_POST,"crypt", FILTER_SANITIZE_STRIPPED); 

            return [
                "crypt" => $crypt,
                "name" => $name,
                "tel" => clearChar($tel),
                "email" => $email,
                "subject" => $subject,
                "message" => $message,
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
        
        private function contactValidate(string $redirect) :bool {   

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
                if ($key !== "tel" && $key !== "crypt") {
                    if ($value === "") {
                        $missingFields[] = $key;
                    }
                }
            }

            return $missingFields;

        }

        /*grava um contato na base de dados */
        public function store(Request $request)  {

            $this->contactValidate("/contato");

            $missingFields = $this->missingFields();

            if ( !is_null( $missingFields ) ) {

                $missingFields = implode (",", $missingFields);
                $missingFields = substr($missingFields, 0, -1);
                error("O(s) campo(s) " . $missingFields . " precisam de atenção");
                return redirectToRoute(route("contact.create"));

            }

            $formFields =  array_splice($this->formFields(), 1);

            $contact = $this->contactsModel->store($formFields);

            if  (!$contact) {
                
                error("Erro no envio da mensagem!");

                return redirectToRoute(route("contact.create"));
    
            }  
            
            success("Mensagem efetuada com sucesso!");

            return redirectToRoute(route("contact.create"));

        }

        /*carrega o formulário para edição de um contato */
		public function show (int $id) {
            
            $contact = $this->contactsModel->find($id);
            
            if ( is_null($contact) ) {
                return redirectToRoute(route("error.404"));
            }             
                            
            return loadTemplate("admin/contactShow", ["contact"=>$contact], "admin");
                
		}

		/*grava a edição de um contato */
        public function update(Request $request) {           
            
            $id = filter_input(INPUT_POST,"id", FILTER_VALIDATE_INT);

            if (!$id) {
                
                error("Campo ID não enviado");

                return redirectToRoute(route("contact.ecit",[$id]));

            } 

            $this->contactValidate("/contato/edit/" . $id); 

            $missingFields = $this->missingFields();

            if ( !is_null( $missingFields ) ) {

                $missingFields = implode (",", $missingFields);
                $missingFields = substr($missingFields, 0, -1);
                error("O(s) campo(s) " . $missingFields . " precisam de atenção");    
                return redirectToRoute(route("contact.ecit",[$id]));

            }

            $formFields =  array_splice($this->formFields(), 1);

            $contact = $this->contactsModel->update($formFields, $id);     

            if  (!$contact) {
                
                error("Erro na edição da mensagem!");

                return redirectToRoute(route("contact.ecit",[$id]));
    
            }             
            
            success("Atualização efetuada com sucesso!");

            return redirectToRoute(route("contact.ecit",[$id]));

        }
		
		/* Esse método exclui um registro com um determinado id */
		
		public function delete (Request $request) {       
            
            $id = filter_input(INPUT_POST,"id", FILTER_VALIDATE_INT);

            if (!$id) {
                error("Campo ID não enviado");
                return redirectToRoute(route("contact"));
            }

            $this->contactsModel->delete($id);
            return redirectToRoute(route("contact"));
            
        }
		

    }