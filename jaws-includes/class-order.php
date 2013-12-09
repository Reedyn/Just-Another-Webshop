<?php
include '../jaws-includes/db.php';

function getOrder($orderId) {
    // Return a order with a specific Id.
}

function getOrders() {
    // Return an array of all orders with relevant data.
}

class Order {
    protected $orderId;
    protected $personalNr;
    protected $time;
    protected $discount;
    protected $card;
    protected $productList[];

    public function __construct($orderId, $personalNr, $discount, $card, $productList) {
        $this->orderId      = $orderId;
        $this->personalNr   = $personalNr;
        $this->price        = $price;
        $this->discount     = $discount;
        $this->card         = $card;
        $this->productList  = $productList;
    }
    
    public function getorderId() {
        return $this->orderId;
    }
    
    public function getPersonalNr() {
        return $this->personalNr;
    }
    
    public function getTime() {
        return $this->time;
    }
    
    public function getDiscount() {
        return $this->discount;
    }
    
    public function getCard() {
        return $this->card;
    }
    
    public function setCard($card) {
        $this->card = $card;
    }
    
    public function getProductList() {
        return $this->productList;
    }
    
    public function addProduct($productId, $amount) {
        $this->productList[] = new ListedProduct($productId, $amount);
    }
    
    public function removeProduct($productId){
        for ($i = 0; $i < sizeof($arr); $i++;){
            if ($this->productList[$i]->getProductId() == $productId) {
                unset($this->productList[$i])
                return true;
            }
        }        
        return false;
    }
    
    public function setProductAmount($productId, $amount){
        for ($i = 0; $i < sizeof($arr); $i++;){
            if ($this->productList[$i]->getProductId() == $productId) {
                $this->productList[$i]->setAmount($amount);
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
        return this->$productId;
    }
    
    public function getAmount(){
        return this->$amount;
    }
    
    public function setAmount($amount){
        $this->amount = $amount;
    }
}

?>