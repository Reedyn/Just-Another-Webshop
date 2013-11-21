<?php
include '../jaws-includes/db.php';

function getPurchase($purchaseId) {
    // Return a purchase with a specific Id.
}

function getPurchases() {
    // Return an array of all purchases with relevant data.
}

class Purchase {
    protected $purchaseId;
    protected $personalNr;
    protected $time;
    protected $discount;
    protected $card;
    protected $productList;

    public function __construct($purchaseId, $personalNr, $discount, $card, $productList) {
        $this->purchaseId   = $purchaseId;
        $this->personalNr   = $personalNr;
        $this->price        = $price;
        $this->discount     = $discount;
        $this->card         = $card;
        $this->productList  = $productList;
    }
    
    public function getPurchaseId() {
        return $this->purchaseId;
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
    
    public function getProductList)() {
        return $this->productList;
    }
}

?>