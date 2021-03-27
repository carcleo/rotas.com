<?php

use src\view\View;
use src\router\Request;
use src\router\Route;
use src\support\Session;
use src\support\Alerts;
use src\support\Format;


if (!function_exists('loadTemplate')) {	

  function loadTemplate(string $viewName, array $viewData = null, string $template = "site" ) {

    return View::loadTemplate($viewName, $viewData, $template);
	
  }  

}

if (!function_exists('loadView')) {	

  function loadView(string $viewName, array $viewData = null) {
    
    return View::loadView($viewName, $viewData);
	
  }  

}


if (!function_exists('route')) {	

  function route(string $name, array $parameters = NULL) : string {
    
    $request = new Request; 

    return $request->host() . Route::getRouteByNamed($name, $parameters);    
	
  }  
  
}


if (!function_exists('middlewaresRegistered')) {	

  function middlewaresRegistered() {
	  
    return require dirname(__DIR__, 2) . "/config/middlewaresRegistered.php" ;
	
  }  
  
}


if (!function_exists('hash512')) {	

  function hash512() :string{

    $request = new Request; 

    return hash('sha512', $request->secret());
      
  }
  
}


if (!function_exists('encrypt')) {	

  function encrypt() :string {

    $request = new Request; 

    return '<input type="hidden" name="crypt" value="' . hash512() . '">';
      
  }
  
}


if (!function_exists('redirectToRoute')) {	

  function redirectToRoute(string $link) {

    $request = new Request; 
    
    return header("Location: " . $link );
      
  }
  
}


if (!function_exists('env')) {	

  function env(string $envField, string $envOpt = NULL ) {   
    
    $envFile = dirname(__DIR__, 2) . '/.env';
    
    if (file_exists($envFile)) {

      $parsed = parse_ini_file( $envFile, true);   
      
      return
          array_key_exists($envField, $parsed) 
              ? $parsed[$envField]
              : $envOpt;
              
    }

    return $envOpt;
      
  }
  
}

if (!function_exists('env_database')) { 

  function env_database() {
    
    $db = require dirname(__DIR__, 2) . "/config/databases.php";
    
    $environment = env('APP_ENV');
    $driver = env(strtoupper($environment) . '_DB_CONNECTION');
    
    return $db["connections"][$environment][$driver];    
 
  }  
  
}


if (!function_exists('title')) {	

  function title() : string {   

    $request = new Request; 
    
    return  $request->title() ;
      
  }
  
}


if (!function_exists('host')) {	

  function host(string $uri = NULL) : string {   

    $request = new Request; 
    
    return  $request->host() . $uri ;
      
  }
  
}

if (!function_exists('assets')) {	

  function assets(string $uri) : string {   

    $request = new Request; 
    
    return  $request->host() . '/assets/' . $uri ;
      
  }
  
}


if (!function_exists('success')) {	
  
  function success(string $message)  { 

    $return = Alerts::success($message);

  }

}


if (!function_exists('error')) {	
  
  function error(string $message)  { 

    $return = Alerts::error($message);

  }

}


if (!function_exists('response')) {	
  
  function response() : ?string { 

    $return = Session::getResponse();
    Session::unSet("response");
    return $return;

  }

}

if (!function_exists('missingFields')) {	

  function missingFields() : ?string  { 
    $return = Session::getMissingFields();
    Session::unSet("missingFields");
    return $return;
  }

}

if (!function_exists('field')) {	

  function field(string $field) : ?string  { 
    Session::unSet("form", $field);
    return Session::getFormSessions($field);

  }
  
}


if (!function_exists("file_exist")) {

  function file_exist(string $pathFile)  : bool  {
    
    return  file_exists(dirname(__DIR__,2). '/public/assets/' . $pathFile)
                ? true
                : false;
                
  }

}


if (!function_exists("img_exists")) {

  function img_exists(string $pathFile): string {
    
    return  file_exists(dirname(__DIR__,2). '/public/assets/imgs/' . $pathFile)
                ? assets('imgs/' . $pathFile)
                : assets('imgs/semFoto.png');
                
  }

}

if (!function_exists('firstImageProduct')) {	

    function firstImageProduct(int $id) : string  {

        $products = new ProductsModel;
        $image = $products->getFirstImage($id);
        
        return is_null($image)
                  ? assets("imgs/") . "semFoto.png"
                  : (
                      file_exists(dirname(__DIR__,2) . "/public/assets/imgs/products/" . $image)
                        ? assets("imgs/products/") . $image
                        : assets("imgs/") . "semFoto.php"
                    );
    
    }
  
}


if (!function_exists('clearChar')) {	

  function clearChar(string $text) : string {
    return preg_replace ("/[^A-Za-z0-9]/", "", $text);
  }

}


if (!function_exists('onlyNumbers')) {	

  function onlyNumbers(string $text) : string {
    return preg_replace ("/[^0-9]/", "", $text);
  }

}


if (!function_exists('addCents')) {	

  function addCents($value) : string {
    return number_format($value, 2, ',', '.');
  }

}


if (!function_exists('cartCount')) {	

  function cartCount() : string {
    return  (new CartController)->count() > 0
                 ? (new CartController)->count()
                 : 0;
  }

}


if (!function_exists('arrayFotos')) {	      

  function arrayFotos($array1, $array2) {
      
    $novasFotos= array();
    
    if(is_array($array1) && count($array1) > 0) {
        $i = 0;
        foreach($array1 as $value1) {
            foreach($array2["name"] as $key =>$value2) {
                if ($value1 == $value2) {					   
                    if ( $array2["error"][$key] == 0) {
                        $novasFotos[$i]["name"] = $array2["name"][$key];
                        $novasFotos[$i]["type"] = $array2["type"][$key];
                        $novasFotos[$i]["tmp_name"] = $array2["tmp_name"][$key];
                        $novasFotos[$i]["error"] = $array2["error"][$key];
                        $novasFotos[$i]["size"] = $array2["size"][$key];
                    }
                  $i++;
                  break;				 				 
                }
            }
        }
    }
    return $novasFotos;
  }

}


if (!function_exists('dateFormat')) {	

  function dateFormat(string $data) : string {
  
     return (new DateTime($data))->format("d/m/Y");
       
  }

}


if (!function_exists('documentFormat')) {	

  function documentFormat(string $document) : string {
	
  	$formatDocument = new ValidaCPFCNPJ($document);
	 
    return $formatDocument->formata();
       
  }

}


if (!function_exists('telFormat')) {	

  function telFormat(string $tel) : string {
    
    $format = new Format;

    return $format->tel($tel);
       
  }


  if (!function_exists('zipFormat')) {	
  
    function zipFormat(string $zip) : string {
      
      $format = new Format;
  
      return $format->zip($zip);
         
    }
    
  }

  if (!function_exists('strToArray')) {	
  
    function strToArray(string $string) : array {
      
      $array = explode(" ", $string);
  
      return $array;
         
    }
    
  }


  if (!function_exists('slugify')) {	

    function slug($string) {

      $string = preg_replace('/[\t\n]/', ' ', $string);
      $string = preg_replace('/\s{2,}/', ' ', $string);

      $list = array(
          'Š' => 'S',
          'š' => 's',
          'Đ' => 'Dj',
          'đ' => 'dj',
          'Ž' => 'Z',
          'ž' => 'z',
          'Č' => 'C',
          'č' => 'c',
          'Ć' => 'C',
          'ć' => 'c',
          'À' => 'A',
          'Á' => 'A',
          'Â' => 'A',
          'Ã' => 'A',
          'Ä' => 'A',
          'Å' => 'A',
          'Æ' => 'A',
          'Ç' => 'C',
          'È' => 'E',
          'É' => 'E',
          'Ê' => 'E',
          'Ë' => 'E',
          'Ì' => 'I',
          'Í' => 'I',
          'Î' => 'I',
          'Ï' => 'I',
          'Ñ' => 'N',
          'Ò' => 'O',
          'Ó' => 'O',
          'Ô' => 'O',
          'Õ' => 'O',
          'Ö' => 'O',
          'Ø' => 'O',
          'Ù' => 'U',
          'Ú' => 'U',
          'Û' => 'U',
          'Ü' => 'U',
          'Ý' => 'Y',
          'Þ' => 'B',
          'ß' => 'Ss',
          'à' => 'a',
          'á' => 'a',
          'â' => 'a',
          'ã' => 'a',
          'ä' => 'a',
          'å' => 'a',
          'æ' => 'a',
          '@' => '-',
          'ç' => 'c',
          'è' => 'e',
          'é' => 'e',
          'ê' => 'e',
          'ë' => 'e',
          'ì' => 'i',
          'í' => 'i',
          'î' => 'i',
          'ï' => 'i',
          'ð' => 'o',
          'ñ' => 'n',
          'ò' => 'o',
          'ó' => 'o',
          'ô' => 'o',
          'õ' => 'o',
          'ö' => 'o',
          'ø' => 'o',
          'ù' => 'u',
          'ú' => 'u',
          'û' => 'u',
          'ý' => 'y',
          'ý' => 'y',
          'þ' => 'b',
          'ÿ' => 'y',
          'Ŕ' => 'R',
          'ŕ' => 'r',
          '#' => '-',
          '$' => '-',
          '%' => '-',
          '&' => '-',
          '*' => '-',
          '()' => '-',
          '(' => '-',
          ')' => '-',
          '_' => '-',
          '-' => '-',
          '+' => '-',
          '=' => '-',
          '*' => '-',
          '/' => '-',
          '\\' => '-',
          '"' => '-',
          '{}' => '-',
          '{' => '-',
          '}' => '-',
          '[]' => '-',
          '[' => '-',
          ']' => '-',
          '?' => '-',
          ';' => '-',
          '.' => '-',
          ',' => '-',
          '<>' => '-',
          '°' => '-',
          'º' => '-',
          'ª' => '-',
          ':' => '-',
          '!' => '-',
          '¨' => '-',
          ' ' => '-'
      );

      $string = strtr($string, $list);
      $string = preg_replace('/-{2,}/', '-', $string);
      $string = mb_strtolower($string);

      return $string;
      
  }
  
}  

}