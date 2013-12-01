<?php
    //Includes
    include_once 'db.php';
    include 'config.php';

    //Initialize the class Database
    $db=new Database($dbHost,$dbUser,$dbPassword,$dbName);
    //Functions


    function getOrders() { // Returns an order from the order as an Order class.
        $arg_list=func_get_args();

        //Call function in db.php to get the array of users
        $data=call_user_func_array(array($this->db,"dbGetOrders()"),$arg_list);

        $order=NULL;
        for($i=0;$i<count($data);$i++){
            $order[$i]=new User($data[$i]['OrderId'],$data[$i]['SSNr'],$data[$i]['OrderDate'],$data[$i]['Discount'],$data[$i]['ChargedCard'],$data[$i]['ProductList']);
        }
        return $order;
    }

    class Order {
        public $OrderId;
        public $SSNr;
        public $OrderDate;
        public $Discount;
        public $ChargedCard;
        public $ProductList;

        public function __construct($OrderId,$SSNr,$OrderDate,$Discount,$ChargedCard,$ProductList) {
            $this->OrderId      = $OrderId;
            $this->SSNr         = $SSNr;
            $this->OrderDate    = $OrderDate;
            $this->Discount     = $Discount;
            $this->ChargedCard  = $ChargedCard;
            $this->ProductList  = $ProductList;
        }

        public function getOrderId() {
            return $this->OrderId;
        }

        public function getSSNr() {
            return $this->SSNr;
        }

        public function getOrderDate() {
            return $this->OrderDate;
        }

        public function getDiscount() {
            return $this->Discount;
        }

        public function getChargedCard() {
            return $this->ChargedCard;
        }

        public function setChargedCard($NewCard) {
            $this->card = $NewCard;
        }

        public function getProductList() {
            return $this->ProductList;
        }

        public function addProduct($ProductId, $Amount) {
            $this->ProductList= new ListedProduct($ProductId,$Amount);
        }

        public function removeProduct($ProductId){
            for ($i = 0; $i < sizeof($arr); $i++;){
                if ($this->ProductList[$i]->getProductId() == $ProductId) {
                    unset($this->productList[$i]);
                    return true;
                }
            }
            return false;
        }

        public function setProductAmount($productId, $amount){
            for ($i = 0; $i < count($this->ProductList); $i++;){
                if ($this->ProductList[$i]->getProductId() == $productId) {
                    $this->ProductList[$i]->setAmount($amount);
                    return true;
                }
            }
            return false;
        }
    }

    class ListedProduct {
        protected $productId;
        protected $amount;

        public function __construct($productId, $amount) {
            $this->productId    = $productId;
            $this->amount       = $amount;
        }

        public function getProductId(){
            return $this->$productId;
        }

        public function getAmount(){
            return $this->$amount;
        }

        public function setAmount($amount){
            $this->amount = $amount;
        }
    }

?>