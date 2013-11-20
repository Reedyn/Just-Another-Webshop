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
            printf("User successfully created.\n");
        }
        return true or false;
    }
    
    public function editUser() { // Edits a user and returns a boolean.
        return true or false;
    }
    
    public function deleteUser($SSNr) { // Returns a user.
        if(mysqli_query($database, "DELETE FROM users WHERE SSNr='"$SSNr"'")){
            printf("User Successfully deleted.\n");
        }
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
    
    public function addCard($CardId,$CardNr,$CardName,$ExpiryMonth,$ExpiryYear) { // Adds a card
         if (mysqli_query($database, "INSERT INTO cards SET CardId='"$CardId"',CardNr='"$CardNr"',CardName='"$CardName"',ExpiryMonth='"$ExpiryMonth"', ExpiryYear='"$ExpiryYear"'") === TRUE) {
             printf("Card successfully added.\n");
         }
    }
    
    public function removeCard($CardId) { // Removes a card
    if(mysqli_query($database, "DELETE FROM cards WHERE CardNr='"$CardId"'")){
        printf("Card successfully deleted.\n");
    }
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