<?php

	namespace src\router;

	class Route {
	   
		protected static $router;
		
		protected function __construct() {}
		
		protected static function getRouter() {
			
			if (  is_null (self::$router) )
				self::$router = new Router;
			
			return self::$router;
			
		}		
		
		public static function name($name){
			return static::getRouter()->name($name);
		}		
		
		public static function getRouteByNamed($name, array $parameters = NULL){
			return static::getRouter()->getRouteByNamed($name, $parameters);		
		}		
		
		public static function getRoutesNamed(){
			return static::getRouter()->getRoutesNamed();
		}	
		
		public static function group (array $actributes, $callback) {			
			self::getRouter()->group($actributes, $callback);	
			return new static();		
		}	   

		public static function get(string $route, $callback){
		   self::getRouter()->routesGet($route, $callback);
		   return new static();
		}  

		public static function post(string $route, $callback){
		   self::getRouter()->routesPost($route, $callback);
		   return new static();
		}  

		public static function put(string $route, $callback){
		   self::getRouter()->routesPut($route, $callback);
		   return new static();
		}  

		public static function delete(string $route, $callback){
		   self::getRouter()->routesDelete($route, $callback);
		   return new static();
		}
		
		public static function getRoutes() : ?array{
		   return self::getRouter()->getRoutes();		   
		}	

		public static function dispatcher () {
		   return self::getRouter()->dispatcher();
		}	
		
	}

?>