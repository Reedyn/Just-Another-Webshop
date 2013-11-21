<?php 
include '../jaws-includes/db.php';
function getProducts(){
    return dbGetProducts();
}

function getProduct($productId) { // Returns a user from the database as a User class.
    $productData = dbGetProduct();
    $product = new Product($productData['productId'], $productData['name'], $productData['price'], $productData['stock'], $productData['imageUrl'], $productData['category']);
    return $product;
}

class Product{
    private $productId;
    private $name;
    private $price;
    private $stock;
    private $imageUrl;
    private $category;

    public function __construct($productId, $name, $price, $stock, $imageUrl, $category) {
        $this->productId    = $productId;
        $this->name         = $name;
        $this->price        = $price;
        $this->stock        = $stock;
        $this->imageUrl     = $imageUrl;
        $this->category     = $category;
    }
    public function getProductId(){
        return $this->productId;
    }
    
    public function setProductId($productId){
        $this->productId = $productId;
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function setName($name){
        $this->name = $name;
    }
    
    public function getPrice(){
        return $this->name;
    }
    
    public function setPrice($price){
        $this->price = $price;
    }
    
    public function inStock(){
        if ($this->stock > 0){
            return true;
        } else {
            false;
        }
    }
    
    public function getStock(){
        return $this->name;
    }
    
    public function setStock($stock){
        $this->stock = $stock;
    }
    
    public function getImage(){
        return $this->imageUrl;
    }
    
    public function setImage($imageUrl){
        $this->$imageUrl = $imageUrl;
    }
    
    public function getCategory(){
        
    }
    
    public function setCategory(){
        
    }
}

?>