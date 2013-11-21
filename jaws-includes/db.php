<?php

class Database {
    private $database;

    public function __construct($dbHost,$dbUser,$dbPassword,$dbName) {
        $this->database = mysqli_connect($dbHost,$dbUser,$dbPassword,$dbName) or die("Error " . mysqli_error($this->database));
        echo "Connect attempt!";
    }
    
    /*  #################################
        User
    */  #################################

    public function dbAddUser($SSNr,$Mail,$Password,$FirstName,$LastName,$StreetAddress,$PostAddress,$City,$Telephone) { // Adds a user to the database.
        if (mysqli_query($this->database, "INSERT INTO users (SSNr,Mail,Password,FirstName,LastName,StreetAddress,PostAddress,City,Telephone) VALUES ('$SSNr','$Mail','$Password','$FirstName','$LastName','$StreetAddress','$PostAddress','$City','$Telephone')") === TRUE) {
            echo "success addUser\n";
            return true;
        }else{
            echo "failure addUser\n";
            return false;
        }
    }
    public function dbEditUser($SSNr,$ChangedRow,$ChangeRowValue) { // Edits a user and returns a boolean.
        if(mysqli_query($this->database, "UPDATE users SET $ChangedRow='$ChangeRowValue' WHERE SSNr=$SSNr")===TRUE){
            echo "success editUser\n";
            return true;
        }else{
            echo "failure editUser\n";
            return false;
        }
    }
    
    public function dbDeleteUser($SSNr) { // Returns true if success,false if failed
        if(mysqli_query($this->database, "DELETE FROM users WHERE SSNr='$SSNr'")===TRUE){
            echo "success deleteUser\n";
            return true;
        }else{
            echo "FAILURE deleteUser\n";
            return false;
        }
    }
    
    public function dbGetUser($SSNr) { // Returns a user.
        $result=mysqli_query($this->database, "SELECT * FROM users WHERE SSNr='$SSNr'");
        if($result===TRUE){
            return true;
        }else{
            return false;
        }
    }
    // Purchase
    
    public function dbGetUsersPurchases($SSNr) {
        $UserPurchases=mysqli_query($this->database, "SELECT * FROM purchases WHERE SSNr='$SSNr'");
        return $UserPurchases;
    }
    
    // Login
    
    public function dbMatchPassword($LoginEmail, $LoginPassword) {
        //NOT DONE-----------------------------------------------------*
        if(mysqli_query($this->database, "SELECT Mail FROM users WHERE Mail='$LoginEmail'")!=FALSE){
            $password=mysqli_query($this->database, "SELECT Password FROM users WHERE Mail='$LoginEmail'");
            if($password==$LoginPassword){
                return true;
            }
        }else{
            return false;
        }
    }
    
    // Card
    
    public function dbAddCard($CardId,$CardNr,$CardName,$ExpiryMonth,$ExpiryYear) { // Adds a card
         if (mysqli_query($this->database, "INSERT INTO cards SET CardId='$CardId',CardNr='$CardNr',CardName='$CardName',ExpiryMonth='$ExpiryMonth', ExpiryYear='$ExpiryYear'") === TRUE) {
             return true;
         }else{
            return false;
        }
    }
    
    public function dbRemoveCard($CardId) { // Removes a card
        if(mysqli_query($this->database, "DELETE FROM cards WHERE CardNr='$CardId'")===TRUE){
            return true;
        }else{
            return false;
        }
    }

    
    /*  #################################
        Purchase
    */  #################################

    private function dbAddPurchaseList() {
        //LOOP THROUGH ARRAY AND ADD EVERY ROW INTO TABLE
        return true;

    }

    public function dbAddPurchase($SSNr,$Discount,$ChargedCard,$purchaseList) { // Adds a purchase to the database.
        //NOT DONE ----------------------------------------------------------------------------------------------------*
        $time = getUnixTime(); // Get unixtime
        if(mysqli_query($this->database, "INSERT INTO purchases SET SSNr='$SSNr' PurchaseDate='$time',Discount='$Discount',ChargedCard='$ChargedCard'")===TRUE){
            // ADD PURCHASE TO TABLES
            dbAddPurchaseList($purchaseList,$purchaseId); // Call function for adding a purchaseList into the appropriate table.
            return true;
        }else{
            return false;
        }
    }
    
    public function dbEditPurchase($PurchaseId,$ChangedRow,$ChangeRowValue) { // Edit a purchase
        if(mysqli_query($database, "UPDATE purchases SET $ChangedRow='$ChangeRowValue' WHERE PurchaseId='$PurchaseId'")===TRUE){
            return true;
        }else{
            return false;
        }
    }
    
    public function dbRemovePurchase($PurchaseId) { // Removes a purchase and associated purchased items (purchaseList)
        if(mysqli_query($this->database, "DELETE FROM purchases WHERE PurchaseId='$PurchaseId'")===TRUE){
            if(mysqli_query($this->database, "DELETE FROM purchase_list WHERE PurchaseId='$PurchaseId'")===TRUE){
                return true;
            }else{
                echo "deletes from purchase_list failed";
                return false;
            }
        }
        else{
            echo "deletes from purchases failed";
            return false;
        }
    }
    
    public function dbGetPurchase($purchaseId) { // Returns a purchase
        return true;
    }
    
    /*  #################################
        Product
    */  #################################
    
    public function dbSearchProducts($SearchQuery){ //Return an array of items matching query
        return true;
    }
    
    public function dbAddProduct($Name,$Category,$Price,$Stock) { // Adds a product to the database.
        if(mysqli_query($this->database, "INSERT INTO products SET Name='$Name',Category='$Category',Price='$Price',Stock='$Stock'")===TRUE){
            return true;
        }else{
            return false;
        }
    }
    
    public function dbEditProduct($ProductId,$ChangedRow,$ChangeRowValue) { // Edits a product and returns a boolean.
        if(mysqli_query($this->database, "UPDATE products SET $ChangedRow='$ChangeRowValue' WHERE ProductId='$ProductId'")===TRUE){
            return true;
        }else{
            return false;
        }
    }
    
    public function dbDeleteProduct($ProductId) { // Removes a product from table
        if(mysqli_query($this->database, "DELETE FROM products WHERE ProductId='$ProductId'")===TRUE){
            return true;
        }else{
            return false;
        }
    }
    
    public function dbGetProduct() { // Returns a product.
        return true;
    }
    
    public function dbGetProducts() { // Returns an array of products.
        return true;
    }
    
    /*  #################################
        Category/Taxanomies TO BE DETERMINED
    */  #################################     
}