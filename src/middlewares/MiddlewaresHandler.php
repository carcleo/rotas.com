<?php

    namespace src\middlewares;

    use src\router\Request;
    use src\middlewares\Middlewares;

    class MiddlewaresHandler  {
        
        public function __construct() {}

        private function call (Middlewares $middleware, Request &$request, \Closure $next) {
            return call_user_func_array([$middleware, "handler"], [$request, $next]);
        }

        public function execute (array $middlewares, Request $request)   {
            
            $middlewaresRegistered = middlewaresRegistered();
            
            foreach($middlewares as $middleware) {	
                
                !array_key_exists($middleware, $middlewaresRegistered) &&  class_exists( $middlewaresRegistered[$middleware] )              
                    ? redirectToRoute(route("error.403"))
                    : $this->call( 
                        new $middlewaresRegistered[$middleware], 
                        $request, 
                        function($next) {
                            return $next;
                        }
                    );
                        
            }

        }
        
    }

?>    