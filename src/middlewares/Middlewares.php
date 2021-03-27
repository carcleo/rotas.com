<?php

    namespace src\middlewares;

    use src\router\Request;

    interface Middlewares {

        public function handler (Request $request, \Closure $next);

    }

?>    