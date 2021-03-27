<?php

    namespace src\view;

    use src\support\Session;

    class Menu {

        private $panelLogin;
        private $medias;
        private $menu;
        private $divMenu;
        private $ulMenu;
        private $products;
        private $sessionAdmim;

        public function __construct()  {  

            $this->medias = "<section  class='medias'>
                               <ul>
                                    <li></li>        
                                    <li>
                                        <a href='" . route("web.home") . "'><img src='" . assets('/imgs/home.jpg') . "'></a>
                                    </li>                        
                                    <li>
                                        <div>
                                            <a href='https://www.facebook.com/seu-face' target='_blank'>
                                                <img src='" . assets('/imgs/face.png') . "'>
                                            </a>
                                        </div>   
                                        <div>
                                            <a target='blank' href='https://api.whatsapp.com/send?1=pt_BR&phone=55seu-fone-com-ddd'>
                                                <img src='" . assets("imgs/whatsapp.png") . "'>
                                            </a> 
                                        </div>   
                                    </li>
                                </ul>
                             </section>";

            $this->divMenu = "<div>
                                <img src='" . assets("imgs/btn-menu.png") . "'>
                                <label>Menu</label>
                                <span></span>
                            </div>
                            <div>
                                <img src='" . assets("imgs/btn-menu.png") . "'>
                                <label>Menu</label>
                                <span></span>
                              </div>";


            $this->sessionAdmim = ""; 
            if(Session::has("sessionAdmin")) {
                if (Session::get("sessionAdmin")["privilege"]==="Super") { 

                    $this->sessionAdmim.= " 
                            <a href='#'>Administradores</a>
                            <ul>
                                <li><a href='" . route("admin.create") . "'>Cadastrar</a></li>
                                <li><a href='" . route("admins.listAll") . "'>Listar</a></li>
                                <li><a href='" . route("admin.edit", [(Session::get("sessionAdmin"))["id"]]) . "'>Alterar</a></li>
                                <li><a href='" . route("admin.logout") . "'>Sair</a></li>
                            </ul>"; 

                } else { 

                    $this->sessionAdmim.= " 
                            <a href='#'>Administrador</a>
                            <ul>
                                <li><a href='" . route("admin.edit", [(Session::get("sessionAdmin"))["id"]]) . "'>Alterar</a></li>
                            </ul>";

                }  
            }
        }

        public function ulMenu() {
            
            return  $this->ulMenu;

        }

        public function home() {
            
            return  "<section class='header'>" . $this->medias . $this->menu . "</section>" ;

        }

        public function admin() {            
        
            return "<section class='header'>
            
                        <section class='menu'>

                           " . $this->divMenu . "

                            <ul >
                                <li><a href='" . route("web.home") . "'>Site</a>
                                <li>" . $this->sessionAdmim . "</li>
                                <li>
                                    <a href='#'>Categorias</a>
                                    <ul>
                                        <li><a href='" . route("admin.category.create") . "'>Cadastrar Categoria</a></li>
                                        <li><a href='" . route("admin.categories.listAll") . "'>Listagem de Categoria</a></li>
                                    </ul>
                                </li>
                            </ul>

                        </section>
                        
                    </section>";

        }


    }    

?>
