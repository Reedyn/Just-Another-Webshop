<?php
include '../jaws-includes/db.php';

getPurchase($purchaseId){
    // Return a purchase with a specific Id.
}

getPurchases(){
    // Return an array of all purchases with relevant data.
}

class Purchase{
    private $purchaseId;
    private $personalNr;
    private $time;
    private $discount;
    private $card;
    private $productList;

    public function __construct($purchaseId, $personalNr, $discount, $card, $productList) {
        $this->productId    = $productId;
        $this->name         = $name;
        $this->price        = $price;
        $this->stock        = $stock;
        $this->imageUrl     = $imageUrl;
        $this->category     = $category;
    }
}

?>