<?php

    namespace src\support;

    use mvc\models\imagesProductsModel;

    class Upload {

        private $maxFileSize;
        private $imagesProductsModel;
        private $types;

        public function __construct()  {
            $this->maxFileSize = 5000000;
            $this->imagesProductsModel = new ImagesProductsModel;
            $this->types = [
                "jpg",
                "jpeg",
                "png",
                "gif"
            ];
        }

        public function executeAll(array $images, int $idProduct) {

            if ( count($images) > 0 ) {

                foreach($images as $image) {

                    if($image["size"] < $this->maxFileSize) {
                        
                        $ext = pathinfo($image["name"], PATHINFO_EXTENSION);       

                        if(in_array($ext, $this->types)){    

                            $imageUpload= md5($image["name"]) . '.' . $ext;

                            if (!$this->imagesProductsModel->searchImageOfProduct($idProduct, $imageUpload)) {

                                $this->storeImage($idProduct, $imageUpload);
                                
                                if ( !file_exist("imgs/products/" . $imageUpload) ) {

                                    $path = dirname(__DIR__,2) . "/public/assets/imgs/products/" . $imageUpload;
                                    
                                    $this->move_file($image["tmp_name"], $path);

                                }
                                
                            }

                        }

                    }
                    
                }

            }

        }


        public function executeOne(array $image) : string{

            if ( !is_null($image) ) {

                if($image["size"] < $this->maxFileSize) {
                    
                    $ext = pathinfo($image["name"], PATHINFO_EXTENSION);       

                    if(in_array($ext, $this->types)){    

                        $imageUpload= md5($image["name"]) . '.' . $ext;

                        if ( !file_exist("imgs/categories/" . $imageUpload) ) {

                            $path = dirname(__DIR__,2) . "/public/assets/imgs/categories/" . $imageUpload;
                            
                            $this->move_file($image["tmp_name"], $path);

                        }

                    }

                }
                
            }
            return $imageUpload;

        }

        private function move_file(string $tmp_name, string $path) {
            
            move_uploaded_file($tmp_name, $path);

        }

        private function storeImage(int $idProduct, string $image) {
                       
            $this->imagesProductsModel->insertImageIntoProduct($idProduct, $image);

        }

        public function dropImages(array $imagesBase) {    
            
            foreach($imagesBase as $image) {      
                $imagesProduct = $this->imagesProductsModel->find($image);
                $imageName = $imagesProduct["image"];                  
                $this->imagesProductsModel->delete($image);
                $this->removeImageFromDisc("products/".$imageName);
            }
                
        }

        public function removeImageFromDisc(string $path) {
            $src = dirname(__DIR__,2) . "/public/assets/imgs/" . $path;
            unlink($src);
        }


    }


?>    