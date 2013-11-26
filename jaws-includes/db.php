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
    public function dbEditUser($SSNr) { // Edits a user and returns a boolean.
        $numargs=func_num_args();
        $arg_list=func_get_args();
        $param="";
        for($i=1;$i<$numargs;$i++){
            if($i==$numargs-2){
                $param.=$arg_list[$i]."='";
                $i++;
                $param.=$arg_list[$i]."'";
            }else{
                $param.=$arg_list[$i]."='";
                $i++;
                $param.=$arg_list[$i]."',";
            }
        }
        if(mysqli_query($this->database, "UPDATE users SET $param WHERE SSNr=$SSNr")===TRUE){
            echo "success editUser\n";
            return true;
        }else{
            echo "failure editUser\n";
            return false;
        }
    }
    
    public function dbDeleteUser() { // Returns true if success,false if failed
        $numargs=func_num_args();
        if(!$numargs){
            if(mysqli_query($this->database, "DELETE FROM users")===TRUE){
                mysqli_query($this->database,"ALTER TABLE users AUTO_INCREMENT=1");
                return true;
            }else{
                return false;
            }
        }else{
            $param="";
            $arg_list=func_get_args();
            for($i=0;$i<$numargs;$i++){
                if($i==$numargs-1){
                    $param.=$arg_list[$i];
                }else{
                    $param.=$arg_list[$i].',';
                }
            }
            if(mysqli_query($this->database, "DELETE FROM users WHERE SSNr in ($param)")===TRUE){
                return true;
            }else{
                return false;
            }
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
                if($i==$numargs-1){
                    $param.=$arg_list[$i];
                }else{
                    $param.=$arg_list[$i].',';
                }
            }
            $param=$arg_list[$i];
            $result=mysqli_query($this->database, "SELECT * FROM users WHERE SSNr in($param)");
            $i=0;
            while($row=mysqli_fetch_assoc($result)){
                $user_list[$i]=$row;
                $i++;
            }
        }
        var_dump($user_list);
        return $user_list;
    }

    // Orders
    
    public function dbGetUsersOrders() {
        $numargs=func_num_args();
        $arg_list=func_get_args();
        $param="";
        for($i=0;$i<$numargs;$i++){
            if($i==$numargs-1){
                $param.=$arg_list[$i];
            }else{
                $param.=$arg_list[$i].",";
            }
        }
        $result=mysqli_query($this->database, "SELECT * FROM orders WHERE SSNr in ($param)");
        $i=0;
        while($row=mysqli_fetch_assoc($result)){
            $order_list[$i]=$row;
            $i++;
        }
        var_dump($row);
        return $row;
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
    
    public function dbRemoveCard() { // Removes a card
        $numargs=func_num_args();
        $arg_list=func_get_args();
        if($numargs==1 && $arg_list[0]=="ALL"){
            if(mysqli_query($this->database, "DELETE FROM cards")===TRUE){
                return true;
            }else{
                return false;
            }
        }else{
            $param="";
            for($i=0;$i<$numargs;$i++){
                if($i==$numargs-1){
                    $param.=$arg_list[$i];
                }else{
                    $param.=$arg_list[$i].",";
                }
            }
            if(mysqli_query($this->database, "DELETE FROM cards WHERE CardNr in ($param)")===TRUE){
                return true;
            }else{
                return false;
            }
        }
    }

    
    /*  #################################
        Order
    */  #################################

    private function dbGetUnixTime(){
        date_default_timezone_set('Europe/Stockholm');
        return date('o-m-d H:i:s', time());
    }

    private function dbAddOrderList($OrderId) {
        $numargs=func_num_args();
        $arg_list=func_get_args();
        $param="";
        for($i=1;$i<$numargs;$i+=2){
            $k=$i+1;
            if($i==$numargs-2){
                $param.="($OrderId,$arg_list[$i],$arg_list[$k])";
            }else{
                $param.="($OrderId,$arg_list[$i],$arg_list[$k]),";
            }
        }
        echo $param;
        if(mysqli_query($this->database, "INSERT INTO order_list (OrderId,ProductId,Amount) VALUES $param")===TRUE){
            return true;
        }else{
            echo "Fail on order_list";
            return false;
        }
    }

    public function dbAddOrder($SSNr,$Discount,$ChargedCard) { // Adds a order to the database.
        $numargs=func_num_args();
        $arg_list=func_get_args();
        $param=NULL;
        $time = $this->dbGetUnixTime(); // Get unixtime
        if(mysqli_query($this->database, "INSERT INTO orders SET SSNr='$SSNr', OrderDate='$time',Discount='$Discount',ChargedCard='$ChargedCard'")===TRUE){
            $j=0;
            $param[$j]=mysqli_insert_id($this->database);
            $j++;
            for($i=3;$i<$numargs;$i++){
                $param[$j]=$arg_list[$i];
                $j++;
            }
            return call_user_func_array(array($this,"dbAddOrderList"),$param); // Call function for adding a OrderList into the appropriate table.
        }else{
            echo "Fail on order";
            return false;
        }
    }

    
    public function dbEditOrder($OrderId) { // Edit an order
        $numargs=func_num_args();
        $arg_list=func_get_args();
        $param="";
        for($i=1;$i<$numargs;$i++){
            if($i==$numargs-2){
                $param.=$arg_list[$i]."='";
                $i++;
                $param.=$arg_list[$i]."'";
            }else{
                $param.=$arg_list[$i]."='";
                $i++;
                $param.=$arg_list[$i]."',";
            }
        }
        if(mysqli_query($this->database, "UPDATE orders SET $param WHERE OrderId='$OrderId'")===TRUE){
            return true;
        }else{
            return false;
        }
    }
    
    public function dbRemoveOrders() { // Removes a order and associated ordered items (orderList)
        $numargs=func_num_args();
        $arg_list=func_get_args();
        $param="";
        if($numargs==1 && $arg_list[0]="ALL"){
            if(mysqli_query($this->database, "DELETE FROM order_list")===TRUE){
                if(mysqli_query($this->database, "DELETE FROM orders")===TRUE){
                    mysqli_query($this->database,"ALTER TABLE orders AUTO_INCREMENT=1");
                    return true;
                }else{
                    echo "deletes from orders failed";
                    return false;
                }
            }
            else{
                echo "deletes from order_list failed";
                return false;
            }
        }else{
            for($i=0;$i<$numargs;$i++){
                if($i==$numargs-1){
                    $param.=$arg_list[$i];
                }
                else{
                    $param.=$arg_list[$i].',';
                }
            }
            if(mysqli_query($this->database, "DELETE FROM order_list WHERE OrderId in ($param)")===TRUE){
                if(mysqli_query($this->database, "DELETE FROM orders WHERE OrderId in ($param)")===TRUE){
                    return true;
                }else{
                    echo "deletes from orders failed";
                    return false;
                }
            }
            else{
                echo "deletes from order_list failed";
                return false;
            }
        }
    }

    public function dbGetOrders(){ //Returns an array with order arrays. If no argument, returns ALL orders.
        $numargs=func_num_args();
        $arg_list=func_get_args();
        $order_list=NULL;
        if($numargs==1 && $arg_list[0]="ALL"){
            $i=0;
            $result=mysqli_query($this->database, "SELECT * FROM orders");
            while($row=mysqli_fetch_assoc($result)){
                $order_list[$i]=$row;
                $i++;
            }
        }else{
            $param="";
            for($i=0;$i<$numargs;$i++){
                if($i==$numargs-1){
                    $param.=$arg_list[$i];
                }else{
                    $param.=$arg_list[$i].',';
                }
            }
            $result=mysqli_query($this->database, "SELECT * FROM orders WHERE OrderId in($param)");
            $i=0;
            while($row=mysqli_fetch_assoc($result)){
                $order_list[$i]=$row;
                $i++;
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
    
    public function dbEditProduct($ProductId) { // Edits a product and returns a boolean. TRUE for success, FALSE for failure.
        $numargs=func_num_args();
        $arg_list=func_get_args();
        $param="";
        for($i=1;$i<$numargs;$i++){
            if($i==$numargs-2){
                $param.=$arg_list[$i]."='";
                $i++;
                $param.=$arg_list[$i]."'";
            }else{
                $param.=$arg_list[$i]."='";
                $i++;
                $param.=$arg_list[$i]."',";
            }
        }
        if(mysqli_query($this->database, "UPDATE products SET $param WHERE ProductId='$ProductId'")===TRUE){
            return true;
        }else{
            return false;
        }
    }
    
    public function dbDeleteProducts() { // Removes the product with the id matching the argument from table.
        $numargs=func_num_args();
        $arg_list=func_get_args();
        if($numargs==1 && $arg_list[0]="ALL"){
            if(mysqli_query($this->database,"DELETE FROM products")===TRUE){
                mysqli_query($this->database, "ALTER TABLE products AUTO_INCREMENT=1");
                return true;
            }else{
                return false;
            }
        }else{
            $param="";
            for($i=0;$i<$numargs;$i++){
                if($i==$numargs-1){
                    $param.=$arg_list[$i];
                }else{
                    $param.=$arg_list[$i].",";
                }
            }
            if(mysqli_query($this->database, "DELETE FROM products WHERE ProductId in ($param)")===TRUE){
                return true;
            }else{
                return false;
            }
        }
    }

    public function dbGetProducts(){ //Returns an array with product arrays. If no argument, returns ALL products.
        $numargs=func_num_args();
        $arg_list=func_get_args();
        $product_list=NULL;
        if($numargs==1 && $arg_list[0]="ALL"){
            $i=0;
            $result=mysqli_query($this->database, "SELECT * FROM products");
            while($row=mysqli_fetch_assoc($result)){
                $product_list[$i]=$row;
                $i++;
            }
        }else{
            $param="";
            for($i=0;$i<$numargs;$i++){
                if($i==$numargs-1){
                    $param.=$arg_list[$i];
                }else{
                    $param.=$arg_list[$i].',';
                }
            }
            $result=mysqli_query($this->database, "SELECT * FROM products WHERE ProductId in ($param)");
            $i=0;
            while($row=mysqli_fetch_assoc($result)){
                $product_list[$i]=$row;
                $i++;
            }

        }
        var_dump($product_list);
        return $product_list;
    }

    /*  #################################
        Category/Taxanomies
    */  #################################

    public function dbGetProductsFromTaxanomy(){ //Returns an array of product arrays where the Taxanomy is matching the argument.
        $numargs=func_num_args();
        $arg_list=func_get_args();
        $param="";
        for($i=0;$i<$numargs;$i++){
            if($i==$numargs-1){
                $param.=$arg_list[$i];
            }else{
                $param.=$arg_list[$i].",";
            }
        }
        $result= mysqli_query($this->database, "SELECT * FROM products WHERE Taxanomy in ($param)");
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