<?php

    namespace mvc\controllers;
    use src\router\Request;

    class WebController extends Controller {

        public function home() {
            
            $css = '<link type="text/css" rel="stylesheet" href="' . assets("css/slider.css") . '">
                    <link type="text/css" rel="stylesheet" href="' . assets("css/parallax.css") . '">';
            $js = "<script src='" . assets("js/slider.js") . "'></script>
                   <script src='" . assets("js/parallax.js") . "'></script>";
             
            return loadTemplate("site/home", ["css"=>$css, "js"=>$js]);
        }

        public function about(Request $request) {
            return loadTemplate("site/about",["request"=>$request]);
        }

        public function fac() {
            return loadTemplate("site/fac");
        }

    }