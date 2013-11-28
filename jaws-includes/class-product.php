<?php
    //Includes
    include 'db.php';
    include 'config.php';

    //Initialize the class Database
    $db=new Database($dbHost,$dbUser,$dbPassword,$dbName);

    //Functions

    function getProducts() { // Returns a product from the product as a Product class.
        $arg_list=func_get_args();
        $data=call_user_func_array(array($this->db,"dbGetProducts()"),$arg_list);
        $product=NULL;
        for($i=0;$i<count($arg_list)-1;$i++){
            $product[$i]=new Product($data[$i]['ProductId'],$data[$i]['Name'],$data[$i]['Description'],$data[$i]['ImgUrl'],$data[$i]['Taxanomy'],$data[$i]['Price'],$data[$i]['Stock']);
        }
        return $product;
    }

    class Product{
        protected $ProductId;
        protected $Name;
        protected $Description;
        protected $ImgUrl;
        protected $Taxanomy;
        protected $Price;
        protected $Stock;

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
            $this->ProductId = $ProductId;
        }

        public function getName(){
            return $this->Name;
        }

        public function setName($Name){
            $this->Name = $Name;
        }

        public function getDescription(){
            return $this->Description;
        }

        public function setDescription($Description){
            $this->Description=$Description;
        }

        public function getImage(){
            return $this->ImgUrl;
        }

        public function setImage($ImgUrl){
            $this->$ImgUrl = $ImgUrl;
        }

        public function getTaxanomy(){
            return $this->Taxanomy;
        }

        public function setTaxanomy($Taxanomy){
            $this->Taxanomy=$Taxanomy;
        }
        public function getPrice(){
            return $this->Price;
        }

        public function setPrice($Price){
            $this->Price = $Price;
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
            $this->Stock = $Stock;
        }
    }

?>