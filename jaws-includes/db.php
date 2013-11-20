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
    
    public function editUser($ChangedRow,$ChangeRowValue,$SSNr) { // Edits a user and returns a boolean.
        if(mysqli_query($database, "UPDATE users SET "$ChangedRow"='"$ChangeRowValue"' WHERE SSNr='"$SSNr"'")===TRUE){
            return true;
        }else{
            return false;
        }
    }
    
    public function deleteUser($SSNr) { // Returns true if success,false if failed
        if(mysqli_query($database, "DELETE FROM users WHERE SSNr='"$SSNr"'")===TRUE){
            return true;
        }else{
            return false;
        }
    }
    
    public function getUser($SSNr) { // Returns a user.
        $User=mysqli_query($database, "SELECT * FROM users WHERE SSNr='"$SSNr"'");
        return $User;
    }
    // Purchase
    
    public function getUsersPurchases($SSNr) {
        $UserPurchases=mysqli_query($database, "SELECT * FROM purchases WHERE SSNr='"$SSNr"'");
        return $UserPurchases;
    }
    
    // Login
    
    public function matchPassword($LoginEmail, $LoginPassword) {
        if(mysqli_query($database, "SELECT Mail FROM users WHERE Mail='"$LoginEmail"'")!=FALSE){
            $password=mysqli_query($database, "SELECT Password FROM users WHERE Mail='"$LoginEmail"'");
            if($password==$LoginPassword){
                return true;
            }
        }else{
            return false;
        }
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
        if(mysqli_query($database, "DELETE FROM purchases WHERE PurchaseId='"$PurchaseId"'")===TRUE && mysqli_query($database, "DELETE FROM purchase_list WHERE PurchaseId='"$PurchaseId"'")===TRUE){
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
    
    public function editProduct($ProductId) { // Edits a product and returns a boolean.
        if(mysqli_query($database, "UPDATE products SET "$ChangedRow"='"$ChangeRowValue"' WHERE ProductId='"$ProductId"'")===TRUE){
            return true;
        }else{
            return false;
        }
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