<?php

    namespace http\middlewares;

    use src\router\Request;
    use src\middlewares\Middlewares;
    use src\support\Session;

    class AuthAdmin implements Middlewares{

		public function __construct() {}

        public function handler(Request $request, \Closure $next) {
            if ( !Session::has("sessionAdmin") ) {	
                return redirectToRoute(route("admin.login"));  
            } 

            return next($request);
            
        }

    }