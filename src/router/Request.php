<?php

	namespace src\router;

    use src\support\Session;

    class Request {
                
            private  $title;
            private  $address = [];
            private  $servername;
            private  $protocol;
            private  $host;
            private  $method;
            private  $uri;
            private  $viewsPath;
            private  $namespaceModels;
            private  $namespaceControllers;
            private  $secret;
			private  $tel;
        
            public function __construct()  {

                $this->title = "Rotas.com";
                $this->address = [
                    "cep" => 00000000,
                    "rua" => "Tal",
                    "numero" => 0,
                    "bairro" => "Tal",
                    "cidade" => "Tal",
                    "estado" => "Tal"
                ];
                $this->servername = $_SERVER["SERVER_NAME"];
                
                $scheme = isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on" 
                            ? "https"
                            : "http";
                            
                $this->host = $_SERVER["SERVER_NAME"] === "localhost"
                                    ? $scheme . '://' . $_SERVER["HTTP_HOST"] . '/' . strtolower($this->extratDominioFromUri($_SERVER['REQUEST_URI']))
                                    : $scheme . '://' . $_SERVER["HTTP_HOST"];								 
                
                $this->protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http');
                
                $this->uri = $this->extratFromUri($_SERVER['REQUEST_URI'], "rotas.com");
                
                $this->method = $_SERVER['REQUEST_METHOD'];
                
                $this->viewsPath = dirname(__DIR__, 2) .'\mvc\views';
                $this->namespaceModels = 'mvc\\model\\';
                $this->namespaceControllers = 'mvc\\controllers\\';
                $this->secret = "MySecretKey";
				
				$this->tel = "00900000000";
                
            }
            
            public function extratFromUri (string $uri, string $string) :string {
                
                $result = "";
                $explode = explode("/", $uri);
                foreach( $explode as $value) {
                    if ($value !== $string) {
                        $result .= $value . "/";
                    }
                }

                return substr($result, 0, -1);
            }			
            
            public function extratDominioFromUri (string $uri) :string {
                
                $explode = array_filter(explode("/", $uri));
                return $explode[1];
            }		
            
            public function title () :string {
                return $this->title;
            }			
            
            public function address () :array {
                return $this->address;
            }		
            
            public function servername () :string {
                return $this->servername;
            }	
            
            public function host () :string {
                return $this->host;
            }
            
            public function protocol () :string {
                return $this->protocol;
            }

            public function method () :string {
                return $this->method;
            }
            
            public function uri () :string {
                return $this->uri;
            }

            public function viewsPath() :string {
                return $this->viewsPath;
            }
            
            public function namespaceModels() :string {
                return $this->namespaceModels;
            }

            public function namespaceControllers() :string {
                return $this->namespaceControllers;
            }
            
            public function secret() {
                return $this->secret;
            }	
            
            public function tel() {
                return $this->tel;
            }
            
        }
    ?>	