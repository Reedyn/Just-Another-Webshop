<?php

class Database extends mysqli {
    protected $database;
    public function __construct($dbHost,$dbUser,$dbPassword,$dbName) {
        $this->database = mysqli_connect($dbHost,$dbUser,$dbPassword,$dbName) or die("Error " . mysqli_error($this->database));
    }

    /*  ###################################################################################################
        Users
    */  ###################################################################################################

    public function dbAddUser($SSNr,$Mail,$Password,$FirstName,$LastName,$StreetAddress,$PostAddress,$City,$Telephone) { // Attempts to add a user and returns a boolean.
        // Adds one user to the users table.
        // Arguments states what needs to be
        // put in.

        $hashedPassword=$this->PasswordHash($Password);
        if (mysqli_query($this->database, "INSERT INTO users (SSNr,Mail,Password,FirstName,LastName,StreetAddress,PostAddress,City,Telephone) VALUES ('$SSNr','$Mail','$hashedPassword','$FirstName','$LastName','$StreetAddress','$PostAddress','$City','$Telephone')") === TRUE) {
            return true;
        }else{
            return false;
        }
    }
    public function dbEditUser($SSNr) { // Attempts to edit a user and returns a boolean.
        // Function arguments are dynamic meaning
        // the first argument is the ID for User (SSNr).
        // The following arguments follow this pattern
        // (...,RowToChange,ValueToChangeTo...)
        // This works endlessly so as long as the
        // row to change is argument number X
        // where X%2=0 and value to change to
        // is argument number Y=X+1.

        $numargs=func_num_args();
        $arg_list=func_get_args();
        $param="";
        for($i=1;$i<$numargs;$i++){
            if($arg_list[$i]=="Password"){
                $j=$i+1;
                $arg_list[$j]=$this->PasswordHash($arg_list[$j]);
            }
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
        if(mysqli_query($this->database, "UPDATE users SET $param WHERE SSNr='$SSNr'")===TRUE){
            return true;
        }else{
            return false;
        }
    }
    
    public function dbDeleteUsers() { // Attempts to delete users and returns a boolean.
        // Functions has dynamic amount of arguments.
        // If the first and only argument == "ALL",
        // all the users will be deleted and primary key
        // will be reset. Otherwise the function will delete
        // the ID of users (SSNr) that are entered as arguments.
        // Example: dbDeleteUsers(SSNr1,SSNr2,SSNr3...);

        $numargs=func_num_args();
        $arg_list=func_get_args();
        if($numargs==1 && $arg_list[0]="ALL"){
            if(mysqli_query($this->database, "DELETE FROM users")===TRUE){
                mysqli_query($this->database,"ALTER TABLE users AUTO_INCREMENT=1");
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

    public function dbGetUsers(){ //Returns an array with user arrays, NULL/FALSE if none found.
        // Function uses dynamic arguments.
        // To get all users the first and only
        // argument must be "ALL".
        // The arguments for getting a user is
        // the users ID (SSNr) for the user.
        // Works with endless of arguments.
        // Ex: dbGetUsers(user1ssnr,user2ssnr,user3ssnr...);

        $numargs=func_num_args();
        $arg_list=func_get_args();
        $user_list=NULL;
        if($numargs==1 && $arg_list[0]="ALL"){
            $result=mysqli_query($this->database, "SELECT * FROM users");
            $i=0;
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
            $result=mysqli_query($this->database, "SELECT * FROM users WHERE SSNr in($param)");
            $i=0;
            while($row=mysqli_fetch_assoc($result)){
                $user_list[$i]=$row;
                $i++;
            }
        }
        return $user_list;
    }
    
    public function dbGetUsersOrders() {//Returns an array with order arrays, NULL/FALSE if none found.
        // Function uses dynamic arguments.
        // The arguments for getting a users
        // orders is the users ID (SSNr) for
        // the user.
        // Works with endless of arguments.
        // Ex: dbGetUsersOrders(user1ssnr,user2ssnr,user3ssnr...);

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
        return $order_list;
    }

    /*  ###################################################################################################
        Login
    */  ###################################################################################################
    
<<<<<<< HEAD
    public function dbMatchPassword($LoginEmail, $LoginPassword) {// Used to check if login matches database, returns a boolean.
        $result = mysqli_query($this->database, "SELECT SSNr,Mail,Password FROM users WHERE Mail='$LoginEmail'");
        $row = mysqli_fetch_assoc($result);
        $hashedPassword=$this->PasswordHash($LoginPassword);
        if ($row != NULL) {
            if ($LoginEmail==$row['Mail'] && $hashedPassword==$row['Password']) {
                //Return the SSNr may be necessary
                return true;
            }else{
                //We know only the password is wrong
                //But we wont mention it
                return false;
            }
        }else{
            //No mail exists
            return false;
        }
=======
    public function
    
    // Purchase
    
    public function getUsersPurchases() {
        
>>>>>>> develop
    }

    /*  ###################################################################################################
        Cards
    */  ###################################################################################################
    
    public function dbAddCard($CardId,$CardNr,$CardName,$ExpiryMonth,$ExpiryYear) { // Attempts to add a card, returns a boolean.
        // Adds one card to the cards table.
        // Arguments states what needs to be
        // put in.
         if (mysqli_query($this->database, "INSERT INTO cards SET CardId='$CardId',CardNr='$CardNr',CardName='$CardName',ExpiryMonth='$ExpiryMonth', ExpiryYear='$ExpiryYear'") === TRUE) {
             return true;
         }else{
            return false;
        }
    }
    
<<<<<<< HEAD
    public function dbDeleteCards() { // Attempts to remove a card, returns a boolean.
        // Functions has dynamic amount of arguments.
        // If the first and only argument == "ALL",
        // all the users will be deleted and primary key
        // will be reset. Otherwise the function will delete
        // the ID of users (SSNr) that are entered as arguments.
        // Example: dbDeleteUsers(SSNr1,SSNr2,SSNr3...);
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
=======
    public function login($email,$password){
        
        // SAVE SESSIONKEY TO USER IN TABLE
        return $sessionKey and $//if successful
    }
    
    // Card
    
    public function addCard($CardId,$CardNr,$CardName,$ExpiryMonth,$ExpiryYear) { // Adds a card
         if (mysqli_query($database, "INSERT INTO cards SET CardId='"$CardId"',CardNr='"$CardNr"',CardName='"$CardName"',ExpiryMonth='"$ExpiryMonth"', ExpiryYear='"$ExpiryYear"'") === TRUE) {
             printf("Card successfully added.\n");
         }
>>>>>>> develop
    }

    public function dbGetCards(){ //Attempts to get cards, returns an array with card arrays. If failure returns NULL.
        // Function uses dynamic arguments.
        // To get all users the first and only
        // argument must be "ALL".
        // The arguments for getting a card is
        // the card ID (CardId) for the order.
        // Works with endless of arguments.
        // Ex: dbGetCards(CardId1,CardId2,CardId3...);

        $numargs=func_num_args();
        $arg_list=func_get_args();
        $card_list=NULL;
        if($numargs==1 && $arg_list[0]="ALL"){
            $result=mysqli_query($this->database, "SELECT * FROM cards");
            $i=0;
            while($row=mysqli_fetch_assoc($result)){
                $card_list[$i]=$row;
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
            $result=mysqli_query($this->database, "SELECT * FROM cards WHERE CardId in($param)");
            while($row=mysqli_fetch_assoc($result)){
                $card_list[$i]=$row;
                $i++;
            }
        }
        return $card_list;
    }

    /*  ###################################################################################################
        Orders
    */  ###################################################################################################

    public function dbAddOrder($SSNr,$Discount,$ChargedCard) { // Attempts to add an order to the database, returns a boolean.
        // Function arguments have dynamic amount, meaning
        // the first argument is the ID for User (SSNr),
        // the second is discount (Discount) and third is
        // charged card (ChargedCard).
        // The following arguments follow this pattern
        // (...,ProductId,ProductAmount...)
        // This works endlessly so as long as the
        // row to change is argument number X
        // where (X%2=0 && X!=2) and value to change to
        // is argument number Y where Y=X+1.
        // Example: dbAddOrder(SSNr,Discount,ChargedCard,Product1Id,Product1Amount,Product2Id,Product2Amount...);

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
            return false;
        }
    }

    private function dbAddOrderList($OrderId) { // Attempts to add order_list for orders, returns a boolean or a string.
        // This wont be called outside of this file

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
        if(mysqli_query($this->database, "INSERT INTO order_list (OrderId,ProductId,Amount) VALUES $param")===TRUE){
            return true;
        }else{
            $failed_id=mysqli_insert_id($this->database);
            if(mysqli_query($this->database, "DELETE FROM orders WHERE OrderId='$failed_id'")===TRUE){
                return false;
            }else{
                $error_msg="Order was added, order_list failed to add. Tried to delete order but failed";
                return $error_msg;
            }
        }
    }
    
    public function dbEditOrder($OrderId) { // Attempts to edit an order, returns a boolean.
        // Function arguments are dynamic meaning
        // the first argument is the ID for Order (OrderId).
        // The following arguments follow this pattern
        // (...,RowToChange,ValueToChangeTo...)
        // This works endlessly so as long as the
        // row to change is argument number X
        // where X%2=0 and value to change to
        // is argument number Y=X+1.

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
    
    public function dbDeleteOrders() { // Attempts to removes an order and associated ordered items (orderList), returns a boolean.
        // Functions has dynamic amount of arguments.
        // If the first and only argument == "ALL",
        // all the orders(and order_lists) will be deleted and primary key
        // will be reset. Otherwise the function will delete
        // the ID of orders (OrderId) that are entered as arguments.
        // Example: dbDeleteOrders(OrderId1,OrderId2,OrderId3...);

        $numargs=func_num_args();
        $arg_list=func_get_args();
        $param="";
        if($numargs==1 && $arg_list[0]="ALL"){
            if(mysqli_query($this->database, "DELETE FROM order_list")===TRUE){
                if(mysqli_query($this->database, "DELETE FROM orders")===TRUE){
                    mysqli_query($this->database,"ALTER TABLE orders AUTO_INCREMENT=1");
                    return true;
                }else{
                    return false;
                }
            }
            else{
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
                    return false;
                }
            }
            else{
                return false;
            }
        }
    }

    public function dbGetOrders(){ //Attempts to get orders, returns an array with order arrays. If failure returns NULL.
        // Function uses dynamic arguments.
        // To get all users the first and only
        // argument must be "ALL".
        // The arguments for getting an order is
        // the orders ID (OrderId) for the order.
        // Works with endless of arguments.
        // Ex: dbGetOrders(OrderId1,OrderId2,OrderId3...);

        $numargs=func_num_args();
        $arg_list=func_get_args();
        $order_list=NULL;
        if($numargs==1 && $arg_list[0]="ALL"){
            $result=mysqli_query($this->database, "SELECT * FROM orders");
            $i=0;
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
        return $order_list;
    }


     /*  ###################################################################################################
         Products
     */  ###################################################################################################
    
    public function dbSearchProducts($SearchQuery){ //Return an array of products arrays matching argument
        $result=mysqli_query($this->database, "SELECT * FROM products WHERE Name,Description,Taxanomy LIKE '%$SearchQuery%'");
        $search_list=NULL;
        $i=0;
        while($row = mysqli_fetch_assoc($result)){
            $search_list[$i]=$row;
            $i++;
        }
        return $search_list;
    }
    
    public function dbAddProduct($Name,$Description,$ImgUrl,$Taxanomy,$Price,$Stock) { //Attempts to add a product, returns a boolean.
        // Adds one product to the products table.
        // Arguments states what needs to be
        // put in.
        if(mysqli_query($this->database, "INSERT INTO products SET Name='$Name',Description='$Description',ImgUrl='$ImgUrl',Taxanomy='$Taxanomy',Price='$Price',Stock='$Stock'")===TRUE){
            return true;
        }else{
            return false;
        }
    }
    
    public function dbEditProduct($ProductId) { //Attempts to edit a product and returns a boolean.
        // Function arguments are dynamic meaning
        // the first argument is the ID for products (ProductId).
        // The following arguments follow this pattern
        // (...,RowToChange,ValueToChangeTo...)
        // This works endlessly so as long as the
        // row to change is argument number X
        // where X%2=0 and value to change to
        // is argument number Y=X+1.

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
    
    public function dbDeleteProducts() { // Attempts to delete products, returns a boolean.
        // Functions has dynamic amount of arguments.
        // If the first and only argument == "ALL",
        // all the products will be deleted and primary key
        // will be reset. Otherwise the function will delete
        // the ID of products (ProductId) that are entered as arguments.
        // Example: dbDeleteProducts(ProductId1,ProductId2,ProductId3...);

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

    public function dbGetProducts(){ // Attempts to get products, returns an array of product arrays. Failure returns NULL.
        // Functions has dynamic amount of arguments.
        // If the first and only argument == "ALL",
        // gets all products.
        // Otherwise the function will get from
        // the ID of products (ProductId) that are entered as arguments.
        // Example: dbGetProducts(ProductId1,ProductId2,ProductId3...);

        $numargs=func_num_args();
        $arg_list=func_get_args();
        $product_list=NULL;
        if($numargs==1 && $arg_list[0]="ALL"){
            $result=mysqli_query($this->database, "SELECT * FROM products");
            $i=0;
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
        return $product_list;
    }

    /*  ###################################################################################################
        Category/Taxanomies
    */  ###################################################################################################

    public function dbGetProductsFromTaxanomy(){ //Returns an array of product arrays. Failure returns NULL.
        // Function uses dynamic amount of arguments.
        // Gets products with Taxanomy matching arguments,
        // several arguments possible, need exact match.
        // Example: dbGetProductsFromTaxanomy(Taxanomy1,Taxanomy2...);

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
        return $product_list;
    }

    /*  ###################################################################################################
        Currency
    */  ###################################################################################################

    public function dbGetCurrencies(){ // Attempts to get currencies, returns an array of currency arrays. NULL if failure
        // Functions has dynamic amount of arguments.
        // If the first and only argument == "ALL",
        // gets all currencies.
        // Otherwise the function will get from
        // the ID of currency (CurrencyId) that are entered as arguments.
        // Example: dbGetCurrencies(CurrencyId1,CurrencyId2,CurrencyId3...);


        $numargs=func_num_args();
        $arg_list=func_get_args();
        $currency_list=NULL;
        if($numargs==1 && $arg_list[0]=="ALL"){
            $result=mysqli_query($this->database,"SELECT * FROM currencies");
            $i=0;
            while($row=mysqli_fetch_assoc($result)){
                $currency_list[$i]=$row;
                $i++;
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
            $result=mysqli_query($this->database, "SELECT * FROM currencies WHERE CurrencyId in ($param)");
            $i=0;
            while($row=mysqli_fetch_assoc($result)){
                $currency_list[$i]=$row;
                $i++;
            }
        }
        return $currency_list;
    }


    /*  ###################################################################################################
        Misc functions
    */  ###################################################################################################

    private function PasswordHash($password){ //Returns a string
        // Used for securing password in database

        $salt="3af36986c682ac4";
        $hash = $salt.$password;
        return hash("md5",$hash);
    }

    private function dbGetUnixTime(){ // Returns current time and date
        date_default_timezone_set('Europe/Stockholm');
        return date('o-m-d H:i:s', time());
    }

// END OF CLASS Database
}

?>
