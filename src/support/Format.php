<?php

    namespace src\support;

    class Format {

        public function tel(string $tel) : string {

            $strlen = strlen($tel);

            if ($strlen === 10) {

                $formated  = "(" . substr( $tel, 0, 2 ) . ') ' 
                                 . substr( $tel, 2, 4 ) . ' ' 
                                 . substr( $tel, 6, 4 );
                
                return $formated;

            }

            $formated  = "(" . substr( $tel, 0, 2 ) . ') ' 
                             . substr( $tel, 2, 5 ) . ' ' 
                             . substr( $tel, 7, 4 );
            
            return $formated;

        }

        public function zip(string $zip) : string {

            return   substr( $zip, 0, 2 ) . '.' 
                   . substr( $zip, 2, 3 ) . '-' 
                   . substr( $zip, 5, 3 );

        }


    }