<?php

class Database extends mysqli {
    protected $database;
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
        $row = mysqli_fetch_assoc($result);
        if (!$row)
        {
            echo 'Error - User does not exist';
            exit();
            return false;
        }else{
            var_dump($row);
            return $row;
        }
    }
    // Orders
    
    public function dbGetUsersOrders($SSNr) {
        $result=mysqli_query($this->database, "SELECT * FROM orders WHERE SSNr='$SSNr'");
        $row = mysqli_fetch_assoc($result);
        if (!$row)
        {
            echo 'Error - No order exist for this user';
            exit();
            return false;
        }else{
            var_dump($row);
            return $row;
        }
    }
    
    // Login
    
    public function dbMatchPassword($LoginEmail, $LoginPassword) {
        $result = mysqli_query($this->database, "SELECT SSNr,Mail,Password FROM users WHERE Mail='$LoginEmail'");
        $row = mysqli_fetch_assoc($result);
        if ($row != NULL) {
            // Check to see if mail and password match
            if ($LoginEmail==$row['Mail'] && $LoginPassword==$row['Password']) {
                echo "Login successful as userid ".$row['SSNr'];
                //Return the SSNr may be necessary
                return true;
            }else{
                //We know only the password is wrong
                //But we wont mention it
                echo 'Error invalid mail or password';
                return false;
            }
        }else{
            //No mail exists
            echo 'Error invalid mail or password';
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
        Order
    */  #################################

    private function dbAddOrderList($OrderId) {
        //LOOP THROUGH ARRAY AND ADD EVERY ROW INTO TABLE
        return true;

    }

    public function dbAddOrder($SSNr,$Discount,$ChargedCard) { // Adds a order to the database.
        //NOT DONE ----------------------------------------------------------------------------------------------------*
        $time = getUnixTime(); // Get unixtime
        if(mysqli_query($this->database, "INSERT INTO orders SET SSNr='$SSNr' OrderDate='$time',Discount='$Discount',ChargedCard='$ChargedCard'")===TRUE){
            // ADD ORDER TO TABLES
            dbAddOrderList($OrderId); // Call function for adding a OrderList into the appropriate table.
            return true;
        }else{
            return false;
        }
    }
    
    public function dbEditOrder($OrderId,$ChangedRow,$ChangeRowValue) { // Edit an order
        if(mysqli_query($this->database, "UPDATE orders SET $ChangedRow='$ChangeRowValue' WHERE OrderId='$OrderId'")===TRUE){
            return true;
        }else{
            return false;
        }
    }
    
    public function dbRemoveOrder($OrderId) { // Removes a order and associated ordered items (orderList)
        if(mysqli_query($this->database, "DELETE FROM orders WHERE OrderId='$OrderId'")===TRUE){
            if(mysqli_query($this->database, "DELETE FROM order_list WHERE OrdersId='$OrderId'")===TRUE){
                return true;
            }else{
                echo "deletes from order_list failed";
                return false;
            }
        }
        else{
            echo "deletes from orders failed";
            return false;
        }
    }
    
    public function dbGetOrders($OrderId) { // Returns a order
        $result=mysqli_query($this->database, "SELECT * FROM orders WHERE OrderId='$OrderId'");
        $row = mysqli_fetch_assoc($result);
        if (!$row)
        {
            echo 'Error - order does not exist';
            exit();
            return false;
        }else{
            var_dump($row);
            return $row;
        }
        return true;
    }
    
    /*  #################################
        Product
    */  #################################
    
    public function dbSearchProducts($SearchQuery){ //Return an array of items matching query
        $result=mysqli_query($this->database, "SELECT * FROM products WHERE Name,Category LIKE '%$SearchQuery%'");
        $row = mysqli_fetch_assoc($result);
        if (!$row)
        {
            echo 'Error - Couldnt find anything';
            exit();
            return false;
        }else{
            var_dump($row);
            return $row;
        }
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
    
    public function dbGetProduct($ProductId) { // Returns a product.
        $result=mysqli_query($this->database, "SELECT * FROM products WHERE ProductId='$ProductId'");
        $row = mysqli_fetch_assoc($result);
        if (!$row)
        {
            echo 'Error - Product does not exist';
            exit();
            return false;
        }else{
            var_dump($row);
            return $row;
        }
    }

    public function dbGetAllProducts(){
        $result=mysqli_query($this->database, "SELECT * FROM products");
        while($row=mysqli_fetch_assoc($result)){
            var_dump($row);
        }
        echo 'No more products to display';
    }

    /*  #################################
        Category/Taxanomies
    */  #################################

    public function dbGetProductsFromTaxanomy($Taxanomy){
        $result= mysqli_query($this->database, "SELECT * FROM products WHERE Taxanomy='$Taxanomy'");
        while($row=mysqli_fetch_assoc($result)){
            var_dump($row);
        }
        echo 'No more products with this taxanomy';
    }

}