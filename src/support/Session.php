<?php

    namespace src\support;

    class Session {

        public static function loginAdmin() :bool {
          return self::has("loginAdmin");
        }
        
        /*Cria uma sessão */
        public static function set (string $session, $value) : void {
            $_SESSION[$session] = $value;
        }

        /*Cria uma sessão */
        public static function addAtSession (string $session, string $sub, array $value) : void {
            $_SESSION[$session][$sub] = $value;
        }

        /*altera uma sessão */
        public static function alterSession (string $session, array $value) : void {
            $_SESSION[$session] = array_merge($_SESSION[$session], $value);
        }

        /*apaga uma sessão */
        public static function unSet (string $name, String $param = NULL) : void {
            
            if (is_null($param)) {
                unset($_SESSION[$name]);
            } else {
                unset($_SESSION[$name][$param]);
            }            
        }

        /*destroy toda a sessão */
        public static function destroy () : void {
            session_destroy();
        }

        /*retorna uma sessão caso exista ou NULL caso não exista */
        public static function get (string $name)  {
            return $_SESSION[$name];
        }        

        /*pesquisa se uma sessão existe*/
        public static function has (string $name, int $id = NULL) : bool {   
            
            if (is_null($id)) {
                return isset( $_SESSION[$name] );
            }  
            
            foreach ($_SESSION[$name] as $key=>$value) {
                if($key == $id) {
                    return true;
                }
            }
            
            return false;
            
        }

        /* conta a quantidade de ítens do carrinho */
        public static function count(string $name) :int {   
            return count($_SESSION[$name]);
        }

        /* conta a quantidade de ítens de um produto no carrinho */
        public static function countItem(string $name, int $id, string $prop) :int {   
            return $_SESSION[$name][$id][$prop];
        }

        public static function incrementItem(string $name, int $id, string $prop) :void{        
             $_SESSION[$name][$id][$prop] ++;        
        }

        public static function decrementItem(string $name, int $id, string $prop) :void{                           
            $_SESSION[$name][$id][$prop] --;
        }
        
        /*Recebe um array de dados de formuláio e cria uma sessão */
        public static function setFormSessions(array $inputs) :void{

            foreach($inputs as $key=>$value) { 
                $data[$key] = $value;
            }
            self::set("form",$data);

        }

        /*Obtem um array de dados de formuláio por uma sessão criada*/
        public static function getFormSessions(string $field) : ?string {            
            if (self::has("form")) {
                foreach($_SESSION["form"] as $formField) {
                    if ($formField["field"] === $field) {
                        return $formField["value"];
                    }
                }
            }
            return NULL;
        }

        /*Recebe um array de dados de formuláio e cria uma sessão */
        public static function setMissingFields(array $inputs) {

            foreach($inputs as $key=>$value) {
                $data[$key] = $value;
            }
            
            self::set("missingFields", $data);

        }

        /*Obtem um array de dados de formuláio por uma sessão criada*/
        public static function getMissingFields() : ?string {
            
            if (self::has("missingFields")) {

                $response = "O(s) campo(s) ";

                foreach ($_SESSION["missingFields"] as $failure) {
                    $response .= $failure["field"] . ",";
                }

                $response = substr($response, 0, -1);
                $response .=  " não foi(ram) preenchido(s)";

                self::unSet("missingFields");

                return "<font color='red'>" . $response . "</font>";
                
            }

            return NULL;

        }

        /*Obtem um array de dados de formuláio por uma sessão criada*/
        public static function getResponse() : ?string {
            
            if (self::has("response")) {

                $response = Session::get("response");
                
                return $response["message"];

            }

            return NULL;
            
        }
        

    }