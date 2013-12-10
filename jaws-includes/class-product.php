<?php
    //Includes
    include_once 'db.php';

    //Functions
    function getProducts() { // Returns a product from the product as a Product class.
        global $db;
        $arg_list=func_get_args();
        $data=call_user_func_array(array($db,"dbGetProducts"),$arg_list);
        $products=NULL;
        for($i=0;$i<count($data);$i++){
            $products[$i]=new Product($data[$i]['ProductId'],$data[$i]['Name'],$data[$i]['Description'],$data[$i]['ImgUrl'],$data[$i]['Taxanomy'],$data[$i]['Price'],$data[$i]['Stock']);
        }
        return $products;
    }
    function getProductsFromTaxanomy(){
        global $db;
        $arg_list=func_get_args();
        $data=call_user_func_array(array($db,"dbGetProductsFromTaxanomy"),$arg_list);
        $products=NULL;
        for($i=0;$i<count($data);$i++){
            $products[$i]=new Product($data[$i]['ProductId'],$data[$i]['Name'],$data[$i]['Description'],$data[$i]['ImgUrl'],$data[$i]['Taxanomy'],$data[$i]['Price'],$data[$i]['Stock']);
        }
        return $products;

    }


    class Product{
        public $ProductId;
        public $Name;
        public $Description;
        public $ImgUrl;
        public $Taxanomy;
        public $Price;
        public $Stock;

        public function __construct($ProductId,$Name,$Description,$ImgUrl,$Taxanomy,$Price, $Stock) {
            $this->ProductId    = $ProductId;
            $this->Name         = $Name;
            $this->Description  = $Description;
            $this->ImgUrl       = $ImgUrl;
            $this->Taxanomy     = $Taxanomy;
            $this->Price        = $Price;
            $this->Stock        = $Stock;
        }
        public function getProductId(){
            return $this->ProductId;
        }

        public function setProductId($ProductId){
            global $db;
            if($db->dbEditProduct($this->ProductId,"ProductId",$ProductId)==TRUE){
                $this->ProductId=$ProductId;
            }
            return $this->getProductId();
        }

        public function getName(){
            return $this->Name;
        }

        public function setName($Name){
            global $db;
            if($db->dbEditProduct($this->ProductId,"Name",$Name)==TRUE){
                $this->Name=$Name;
            }
            return $this->getName();
        }

        public function getDescription(){
            return $this->Description;
        }

        public function setDescription($Description){
            global $db;
            if($db->dbEditProduct($this->ProductId,"Description",$Description)==TRUE){
                $this->Description=$Description;
            }
            return $this->getDescription();
        }

        public function getImgUrl(){
            return $this->ImgUrl;
        }

        public function setImgUrl($ImgUrl){
            global $db;
            if($db->dbEditProduct($this->ProductId,"ImgUrl",$ImgUrl)==TRUE){
                $this->ImgUrl=$ImgUrl;
            }
            return $this->getImgUrl();
        }

        public function getTaxanomy(){
            return $this->Taxanomy;
        }

        public function setTaxanomy($Taxanomy){
            global $db;
            if($db->dbEditProduct($this->ProductId,"Taxanomy",$Taxanomy)==TRUE){
                $this->Taxanomy=$Taxanomy;
            }
            return $this->getTaxanomy();
        }
        public function getPrice(){
            return $this->Price;
        }

        public function setPrice($Price){
            global $db;
            if($db->dbEditProduct($this->ProductId,"Price",$Price)==TRUE){
                $this->Price=$Price;
            }
            return $this->getPrice();
        }

        public function inStock(){
            if ($this->Stock > 0){
                return true;
            } else {
                return false;
            }
        }

        public function getStock(){
            return $this->Stock;
        }

        public function setStock($Stock){
            global $db;
            if($db->dbEditProduct($this->ProductId,"Stock",$Stock)==TRUE){
                $this->Stock=$Stock;
            }
            return $this->getStock();
        }
    }

?>