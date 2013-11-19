<?php

class Database {
    private $database = "";
    
    public function __construct($dbHost,$dbUser,$dbPassword,$dbName) {
        $database = mysqli_connect($dbHost,$dbUser,$dbPassword,$dbName) or die("Error " . mysqli_error($database));
    }
    
    /*  #################################
        User
    */  #################################
    
    public function addUser() { // Adds a user to the database.
        return true or false;
    }
    
    public function editUser() { // Edits a user and returns a boolean.
        return true or false;
    }
    
    public function deleteUser() { // Returns a user.
        return true or false;
    }
    
    public function getUser() { // Returns a user.
        return array;
    }
    
    public function getUsers() { // Returns an array of users.
        return array;
    }
    
    // Purchase
    
    public function getUsersPurchases() {
        
    }
    
    // Login
    
    public function matchPassword(string email, string password) {
        return true or false;
    }
    
    // Card
    
    public function addCard() { // Adds a card
        
    }
    
    public function removeCard() { // Removes a card
        
    }
    
    public function editCard() { // May not be needed, cards never get changed.
        
    }
    
    /*  #################################
        Purchase
    */  #################################
    
    public function addPurchase($personalNr,$discount,$chargedCard,$purchaseList) { // Adds a purchase to the database.
        
        $time = getUnixTime(); // Get unixtime
        // ADD PURCHASE TO TABLES
        addPurchaseList($purchaseList,$purchaseId); // Call function for adding a purchaseList into the appropriate table.
        return true/false;
        
    }
    
    private function addPurchaseList($purchaseList,$purchaseId) { 
        // LOOP THROUGH ARRAY AND ADD EVERY ROW INTO TABLE
    }
    
    public function editPurchase($purchaseId) { // Edit a purchase
        return true/false;
    }
    
    public function removePurchase($purchaseId) { // Removes a purchase and associated purchased items (purchaseList)
        return true/false;
    }
    
    public function getPurchase($purchaseId) { // Returns a purchase
        return array;
    }
    
    /*  #################################
        Product
    */  #################################
    
    public function searchProducts($query){ //Return an array of items matching query
        return array;
    }
    
    public function addProduct() { // Adds a product to the database.
        return True/False;
    }
    
    public function editProduct() { // Edits a product and returns a boolean.
        return True/False;
    }
    
    public function deleteProduct() { // Returns a product.
        return True;
    }
    
    public function getProduct() { // Returns a product.
        return array;
    }
    
    public function getProducts() { // Returns an array of products.
        return array;
    }
    
    /*  #################################
        Category/Taxanomies TO BE DETERMINED
    */  #################################     
}