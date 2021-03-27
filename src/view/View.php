<?php

namespace src\view;

use src\router\Request;
use src\support\Session;
use src\view\Menu;

class View {  

  private static $viewsPath  = __DIR__ . '/../../mvc/views/';

  public static function loadTemplate(string $viewName, array $viewData = null, string $template ) {       
    
    $menu  = new Menu();

    $viewData["ulMenu"] = $menu->ulMenu();

    $viewData["menuSite"] = $menu->home();
    
    if(Session::has("sessionAdmin")) {
      $viewData["menuAdmin"] = $menu->admin();  
    }
    
    if (!is_null($viewData)) {
        extract($viewData);
    }
    
    require_once( self::$viewsPath . $template . '.php');    
	
  }

  public static function loadView(string $viewName, array $viewData = null) {
    
    if (!is_null($viewData)) {
        extract($viewData);
    }
    
    require_once( self::$viewsPath . $viewName . '.php');    
	
  }

  
}