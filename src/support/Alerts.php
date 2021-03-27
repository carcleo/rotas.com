<?php

    namespace src\support;

    class Alerts {

        public static function error (string $_error) :void {

            Session::set(
                "response",
                [
                    "error"=>1, 
                    "message"=>"<h2 class='erro'>" . $_error . "</h2>"
                ]
            );

        }

        public static function success (string $_success) :void {

            Session::set(
                "response",
                [
                    "error"=>0, 
                    "message"=>"<h2>" . $_success . "</h2>"
                ]
            );

        }


    }

?>    