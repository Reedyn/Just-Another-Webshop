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
    protected $productList;

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
    
    public function setProductList() {
        
    }
}

?>