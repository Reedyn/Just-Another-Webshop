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

    public function dbGetUsers(){ //Returns an array with user arrays. If no argument, returns ALL users.
        $numargs=func_num_args();
        $arg_list=func_get_args();
        $user_list=NULL;
        if(!$numargs){
            $i=0;
            $result=mysqli_query($this->database, "SELECT * FROM users");
            while($row=mysqli_fetch_assoc($result)){
                $user_list[$i]=$row;
                $i++;
            }
        }else{
            $param="";
            for($i=0;$i<$numargs;$i++){
                $param.=$arg_list[$i].',';
            }
            for($i=0;$i<$numargs;$i++){
                $param=$arg_list[$i];
                $result=mysqli_query($this->database, "SELECT * FROM users WHERE SSNr in($param)");
                $row=mysqli_fetch_assoc($result);
                $user_list[$i]=$row;
            }
        }
        var_dump($user_list);
        return $user_list;
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

    public function dbGetOrders(){ //Returns an array with order arrays. If no argument, returns ALL orders.
        $numargs=func_num_args();
        $arg_list=func_get_args();
        $order_list=NULL;
        if(!$numargs){
            $i=0;
            $result=mysqli_query($this->database, "SELECT * FROM orders");
            while($row=mysqli_fetch_assoc($result)){
                $order_list[$i]=$row;
                $i++;
            }
        }else{
            $param="";
            for($i=0;$i<$numargs;$i++){
                $param.=$arg_list[$i].',';
            }
            for($i=0;$i<$numargs;$i++){
                $param=$arg_list[$i];
                $result=mysqli_query($this->database, "SELECT * FROM orders WHERE OrderId in($param)");
                $row=mysqli_fetch_assoc($result);
                $order_list[$i]=$row;
            }
        }
        var_dump($order_list);
        return $order_list;
    }

    
    /*  #################################
        Products
    */  #################################
    
    public function dbSearchProducts($SearchQuery){ //Return an array of products arrays matching argument
        $result=mysqli_query($this->database, "SELECT * FROM products WHERE Name,Description,Taxanomy LIKE '%$SearchQuery%'");
        $search_list=NULL;
        $i=0;
        while($row = mysqli_fetch_assoc($result)){
            $search_list[$i]=$row;
            $i++;
        }
        var_dump($search_list);
        return $search_list;
    }
    
    public function dbAddProduct($Name,$Description,$ImgUrl,$Taxanomy,$Price,$Stock) { // Adds a product to the database. Returns a boolean, TRUE for success, FALSE for failure.
        if(mysqli_query($this->database, "INSERT INTO products SET Name='$Name',Description='$Description',ImgUrl='$ImgUrl',Taxanomy='$Taxanomy',Price='$Price',Stock='$Stock'")===TRUE){
            return true;
        }else{
            return false;
        }
    }
    
    public function dbEditProduct($ProductId,$ChangedRow,$ChangeRowValue) { // Edits a product and returns a boolean. TRUE for success, FALSE for failure.
        if(mysqli_query($this->database, "UPDATE products SET $ChangedRow='$ChangeRowValue' WHERE ProductId='$ProductId'")===TRUE){
            return true;
        }else{
            return false;
        }
    }
    
    public function dbDeleteProduct($ProductId) { // Removes the product with the id matching the argument from table.
        if(mysqli_query($this->database, "DELETE FROM products WHERE ProductId='$ProductId'")===TRUE){
            return true;
        }else{
            return false;
        }
    }

    public function dbGetProducts(){ //Returns an array with product arrays. If no argument, returns ALL products.
        $numargs=func_num_args();
        $arg_list=func_get_args();
        $product_list=NULL;
        if(!$numargs){
            $i=0;
            $result=mysqli_query($this->database, "SELECT * FROM products");
            while($row=mysqli_fetch_assoc($result)){
                $product_list[$i]=$row;
                $i++;
            }
        }else{
            $param="";
            for($i=0;$i<$numargs;$i++){
                $param.=$arg_list[$i].',';
            }
            for($i=0;$i<$numargs;$i++){
                $param=$arg_list[$i];
                $result=mysqli_query($this->database, "SELECT * FROM products WHERE ProductId in($param)");
                $row=mysqli_fetch_assoc($result);
                $product_list[$i]=$row;
            }
        }
        var_dump($product_list);
        return $product_list;
    }

    /*  #################################
        Category/Taxanomies
    */  #################################

    public function dbGetProductsFromTaxanomy($Taxanomy){ //Returns an array of product arrays where the Taxanomy is matching the argument.
        $result= mysqli_query($this->database, "SELECT * FROM products WHERE Taxanomy='$Taxanomy'");
        $product_list=NULL;
        $i=0;
        while($row=mysqli_fetch_assoc($result)){
            $product_list[$i]=$row;
            $i++;
        }
        var_dump($product_list);
        return $product_list;
    }


}