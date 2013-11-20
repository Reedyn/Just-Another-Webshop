<?php

class Database {
    private $database = "";
    
    public function __construct($dbHost,$dbUser,$dbPassword,$dbName) {
        $database = mysqli_connect($dbHost,$dbUser,$dbPassword,$dbName) or die("Error " . mysqli_error($database));
    }
    
    /*  #################################
        User
    */  #################################
    
    public function addUser($SSNr,$Mail,$FirstName,$LastName,$StreetAddress,$PostAddress,$City,$Telephone) { // Adds a user to the database.

        if (mysqli_query($database, "INSERT INTO users SET SSNr='"$SSNr"',Mail='"$Mail"',FirstName='"$FirstName"',LastName='"$LastName"',StreetAddress='"$StreetAddress"',PostAddress='"$PostAddress"',City='"$City"',Telephone='"$Telephone"'") === TRUE) {
            return true;
        }else{
            return false;
        }
    }
    
    public function editUser() { // Edits a user and returns a boolean.
        return true or false;
    }
    
    public function deleteUser($SSNr) { // Returns a user.
        if(mysqli_query($database, "DELETE FROM users WHERE SSNr='"$SSNr"'")===TRUE){
            return true;
        }else{
            return false;
        }
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
    
    public function addCard($CardId,$CardNr,$CardName,$ExpiryMonth,$ExpiryYear) { // Adds a card
         if (mysqli_query($database, "INSERT INTO cards SET CardId='"$CardId"',CardNr='"$CardNr"',CardName='"$CardName"',ExpiryMonth='"$ExpiryMonth"', ExpiryYear='"$ExpiryYear"'") === TRUE) {
             return true;
         }else{
            return false;
        }
    }
    
    public function removeCard($CardId) { // Removes a card
        if(mysqli_query($database, "DELETE FROM cards WHERE CardNr='"$CardId"'")===TRUE){
            return true;
        }else{
            return false;
    }
    }
    
    public function editCard() { // May not be needed, cards never get changed.
                                 // Will probably use addCard for this if thats the case.
    }
    
    /*  #################################
        Purchase
    */  #################################
    
    public function addPurchase($SSNr,$Discount,$ChargedCard,$purchaseList) { // Adds a purchase to the database.
        
        $time = getUnixTime(); // Get unixtime
        if(mysqli_query($database, "INSERT INTO purchases SET SSNr='"$SSNr"' PurchaseDate='"$time"',Discount='"$Discount"',ChargedCard='"$ChargedCard"'")===TRUE){
            // ADD PURCHASE TO TABLES
            addPurchaseList($purchaseList,$purchaseId); // Call function for adding a purchaseList into the appropriate table.
            return true;
        }else{
            return false;
        }
    }
    
    private function addPurchaseList($purchaseList,$purchaseId) { 
        // LOOP THROUGH ARRAY AND ADD EVERY ROW INTO TABLE
    }
    
    public function editPurchase($purchaseId) { // Edit a purchase
        return true/false;
    }
    
    public function removePurchase($PurchaseId) { // Removes a purchase and associated purchased items (purchaseList)
        if(mysqli_query($database, "DELETE FROM purchases WHERE PurchaseId='"$PurchaseId"'")===TRUE){
            return true;
        }else{
            return false;
        }
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
    
    public function addProduct($Name,$Category,$Price,$Stock) { // Adds a product to the database.
        if(mysqli_query($database, "INSERT INTO products SET Name='"$Name"',Category='"$Category"',Price='"$Price"',Stock='"$Stock"'")===TRUE){
            return true;
        }else{
            return false;
        }
    }
    
    public function editProduct() { // Edits a product and returns a boolean.
        return True/False;
    }
    
    public function deleteProduct($ProductId) { // Removes a product from table
        if(mysqli_query($database, "DELETE FROM products WHERE ProductId='"$ProductId"'")===TRUE){
            return true;
        }else{
            return false;
    }
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