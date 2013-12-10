<?php
    include_once 'config.php';
    $db=new Database($dbHost,$dbUser,$dbPassword,$dbName);

    class Database extends mysqli {
        public function __construct($dbHost,$dbUser,$dbPassword,$dbName) {
            parent::__construct($dbHost,$dbUser,$dbPassword,$dbName);
        }

        /*  ###################################################################################################
            Users
        */  ###################################################################################################

        public function dbAddUser($SSNr,$Mail,$Password,$FirstName,$LastName,$StreetAddress,$PostAddress,$City,$Telephone) { // Attempts to add a user and returns a boolean.
            // Adds one user to the users table.
            // Arguments states what needs to be
            // put in.
            $salt=$this->AddPasswordSalt();

            $hashedPassword=$this->PasswordHash($salt,$Password);
            if ($this->query("INSERT INTO users (SSNr,Mail,Password,FirstName,LastName,StreetAddress,PostAddress,City,Telephone,PwSalt) VALUES ('$SSNr','$Mail','$hashedPassword','$FirstName','$LastName','$StreetAddress','$PostAddress','$City','$Telephone','$salt')") === TRUE) {
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
                    $result=$this->query("SELECT PwSalt FROM users WHERE SSNr='$SSNr'");
                    $row=$result->fetch_assoc();
                    $arg_list[$j]=$this->PasswordHash($row['PwSalt'],$arg_list[$j]);
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
            if($this->query("UPDATE users SET $param WHERE SSNr='$SSNr'")===TRUE){
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
                if($this->query("DELETE FROM users")===TRUE){
                    $this->query("ALTER TABLE users AUTO_INCREMENT=1");
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
                if($this->query("DELETE FROM users WHERE SSNr in ($param)")===TRUE){
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
                $result=$this->query("SELECT * FROM users");
                $i=0;
                while($row=$result->fetch_assoc()){
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
                $result=$this->query("SELECT * FROM users WHERE SSNr in($param)");
                $i=0;
                while($row=$result->fetch_assoc()){
                    $user_list[$i]=$row;
                    $i++;
                }
            }
            return $user_list;
        }

        public function dbGetUsersOrders() {
            //This function is not needed
            // If thats not the case I will
            // make it call the other getOrder function
            $numargs=func_num_args();
            $arg_list=func_get_args();
            $order_list=NULL;
            if($numargs==1 && $arg_list[0]=="ALL"){
                $result=$this->query("SELECT * FROM orders");
                $i=0;
                while($row=$result->fetch_assoc()){
                    $order_list[$i]=$row;
                    $i++;
                }
            }else{
                $param="";
                for($i=0;$i<count($numargs);$i++){
                    if($i==$numargs-1){
                        $param.=$arg_list[$i];
                    }else{
                        $param.=$arg_list[$i].",";
                    }
                }
                $result=$this->query("SELECT * FROM orders WHERE OrderId in ($param)");
                $i=0;
                while($row=$result->fetch_assoc()){
                    $order_list[$i]=$row;
                    $i++;
                }
            }
        }

        /*  ###################################################################################################
            Login
        */  ###################################################################################################


        public function dbMatchPassword($LoginEmail, $LoginPassword) {// Used to check if login matches database, returns a boolean.
            $result = $this->query("SELECT SSNr,Mail,Password,PwSalt FROM users WHERE Mail='$LoginEmail'");
            $row=$result->fetch_assoc();
            $hashedPassword=$this->PasswordHash($row['PwSalt'],$LoginPassword);
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
        }

        public function login($email,$password){

            // SAVE SESSIONKEY TO USER IN TABLE
        }

        /*  ###################################################################################################
            Cards
        */  ###################################################################################################

        public function dbAddCard($CardId,$CardNr,$CardName,$ExpiryMonth,$ExpiryYear) { // Attempts to add a card, returns a boolean.
            // Adds one card to the cards table.
            // Arguments states what needs to be
            // put in.
             if ($this->query("INSERT INTO cards SET CardId='$CardId',CardNr='$CardNr',CardName='$CardName',ExpiryMonth='$ExpiryMonth', ExpiryYear='$ExpiryYear'") === TRUE) {
                 return true;
             }else{
                return false;
            }
        }

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
                if($this->query("DELETE FROM cards")===TRUE){
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
                if($this->query("DELETE FROM cards WHERE CardNr in ($param)")===TRUE){
                    return true;
                }else{
                    return false;
                }
            }
        }



        // Card

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
                $result=$this->query("SELECT * FROM cards");
                $i=0;
                while($row=$result->fetch_assoc()){
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
                $result=$this->query("SELECT * FROM cards WHERE CardId in($param)");
                while($row=$result->fetch_assoc()){
                    $card_list[$i]=$row;
                    $i++;
                }
            }
            return $card_list;
        }

        /*  ###################################################################################################
            Orders
        */  ###################################################################################################

        public function dbAddOrder($SSNr,$Discount,$ChargedCard,$OrderIP) { // Attempts to add an order to the database, returns a boolean.
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

            $this->autocommit(false);
            if($this->query("INSERT INTO orders SET SSNr='$SSNr', OrderDate='$time',Discount='$Discount',ChargedCard='$ChargedCard',OrderIP='$OrderIP'")===TRUE){
                $j=0;
                $param[$j]=$this->insert_id;
                $j++;
                for($i=3;$i<$numargs;$i++){
                    $param[$j]=$arg_list[$i];
                    $j++;
                }
                if(call_user_func_array(array($this,"dbAddOrderList"),$param)){ // Call function for adding a OrderList into the appropriate table.
                    $this->autocommit(true);
                    return true;
                }else{
                    $this->rollback();
                    return false;
                }
            }else{
                $this->rollback();
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
            if($this->query("INSERT INTO order_lists (OrderId,ProductId,Amount) VALUES $param")===TRUE){
                return true;
            }else{
               return false;
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
            if($this->query("UPDATE orders SET $param WHERE OrderId='$OrderId'")===TRUE){
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
                if($this->query("DELETE FROM order_lists")===TRUE){
                    if($this->query("DELETE FROM orders")===TRUE){
                        $this->query("ALTER TABLE orders AUTO_INCREMENT=1");
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
                if($this->query("DELETE FROM order_lists WHERE OrderId in ($param)")===TRUE){
                    if($this->query("DELETE FROM orders WHERE OrderId in ($param)")===TRUE){
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
            $order_list_internal=NULL;
            if($numargs==1 && $arg_list[0]=='ALL'){
                $result=$this->query("SELECT * FROM orders");
                $result_order_list=$this->query("SELECT * FROM order_lists");
                $i=0;
                $k=0;
                $temp=NULL;
                while($row_order_list=$result_order_list->fetch_assoc()){
                    if($row_order_list['OrderId']!=$temp){
                        $k=0;
                    }
                    $order_list_internal[$row_order_list['OrderId']][$k]=$row_order_list;
                    $temp=$row_order_list['OrderId'];
                    $k++;
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
                $result=$this->query("SELECT * FROM orders WHERE OrderId in ($param)");
                $result_order_list=$this->query("SELECT * FROM order_lists WHERE OrderId in ($param)");
                $i=0;
                $k=0;

                $temp=NULL;
                while($row_order_list=$result_order_list->fetch_assoc()){
                    if($row_order_list['OrderId']!=$temp){
                        $k=0;
                    }
                    $order_list_internal[$row_order_list['OrderId']][$k]=$row_order_list;
                    $temp=$row_order_list['OrderId'];
                    $k++;
                }
            }
            while($row=$result->fetch_assoc()){
                $ProductListArray=NULL;
                for($j=0;$j<count($order_list_internal[$row['OrderId']]);$j++){
                    $ProductListArray[count($ProductListArray)]=array($order_list_internal[$row['OrderId']][$j]['ProductId'],$order_list_internal[$row['OrderId']][$j]['Amount']);
                }
                $row['ProductList']=$ProductListArray;
                $order_list[$i]=$row;
                $i++;
            }
            return $order_list;
        }

         /*  ###################################################################################################
             Products
         */  ###################################################################################################

        public function dbSearchProducts($SearchQuery){ //Return an array of products arrays matching argument
            $result=$this->query("SELECT * FROM products WHERE Name,Description LIKE '%$SearchQuery%'");
            $search_list=NULL;
            $i=0;
            while($row=$result->fetch_assoc()){
                $search_list[$i]=$row;
                $i++;
            }
            return $search_list;
        }

        public function dbAddProduct($Name,$Description,$ImgUrl,$Taxanomy,$Price,$Stock) { //Attempts to add a product, returns a boolean.
            // Adds one product to the products table.
            // Arguments states what needs to be
            // put in.
            if($this->query("INSERT INTO products SET Name='$Name',Description='$Description',ImgUrl='$ImgUrl',Taxanomy='$Taxanomy',Price='$Price',Stock='$Stock'")===TRUE){
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
            if($this->query("UPDATE products SET $param WHERE ProductId='$ProductId'")===TRUE){
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
                if($this->query("DELETE FROM products")===TRUE){
                    $this->query("ALTER TABLE products AUTO_INCREMENT=1");
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
                if($this->query("DELETE FROM products WHERE ProductId in ($param)")===TRUE){
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
                if($result=$this->query("SELECT * FROM products")){
                    $i=0;
                    while($row=$result->fetch_assoc()){
                        $product_list[$i]=$row;
                        $i++;
                    }
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

                if($result=$this->query("SELECT * FROM products WHERE ProductId in ($param)")){
                    $i=0;
                    while($row=$result->fetch_assoc()){
                        $product_list[$i]=$row;
                        $i++;
                    }
                }
            }
            return $product_list;
        }

        /*  ###################################################################################################
            Category/Taxanomies
        */  ###################################################################################################
        public function dbAddTaxanomy($TaxanomyName,$TaxanomyParent) { //Attempts to add a product, returns a boolean.
            // Adds one product to the products table.
            // Arguments states what needs to be
            // put in.
            if($this->query("INSERT INTO taxanomies SET TaxanomyName='$TaxanomyName',TaxanomyParent='$TaxanomyParent'")===TRUE){
                return true;
            }else{
                return false;
            }
        }

        public function dbEditTaxanomy($TaxanomyId) { //Attempts to edit a taxanomy and returns a boolean.
            // Function arguments are dynamic meaning
            // the first argument is the ID for taxanomy (TaxanomyId).
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
            if($this->query("UPDATE taxanomies SET $param WHERE TaxanomyId='$TaxanomyId'")===TRUE){
                return true;
            }else{
                return false;
            }
        }

        public function dbDeleteTaxanomies() { // Attempts to delete taxanomies, returns a boolean.
            // Functions has dynamic amount of arguments.
            // If the first and only argument == "ALL",
            // all the taxanomies will be deleted and primary key
            // will be reset. Otherwise the function will delete
            // the ID of taxanomies (TaxanomyId) that are entered as arguments.
            // Example: dbDeleteTaxanomies(TaxanomyId1,TaxanomyId2,TaxanomyId3...);

            $numargs=func_num_args();
            $arg_list=func_get_args();
            if($numargs==1 && $arg_list[0]="ALL"){
                if($this->query("DELETE FROM taxanomies")===TRUE){
                    $this->query("ALTER TABLE taxanomies AUTO_INCREMENT=1");
                    $this->query("INSERT INTO taxanomies SET TaxanomyName='MasterParent'");
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
                if($this->query("DELETE FROM taxanomies WHERE TaxanomyId in ($param)")===TRUE){
                    return true;
                }else{
                    return false;
                }
            }
        }
        public function dbGetTaxanomies(){//Returns an array with taxanomies
            //flexible arguments
            $numargs=func_num_args();
            $arg_list=func_get_args();
            $taxanomy_list=NULL;
            if($numargs==1 && $arg_list[0]=="ALL"){
                $result=$this->query("SELECT * FROM taxanomies");
                $i=0;
                while($row=$result->fetch_assoc()){
                    $taxanomy_list[$i]=$row;
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
                $result=$this->query("SELECT * FROM taxanomies WHERE TaxanomyId in ($param)");
                $i=0;
                while($row=$result->fetch_assoc()){
                    $taxanomy_list[$i]=$row;
                    $i++;
                }
            }
            return $taxanomy_list;
        }
        public function dbGetProductsFromTaxanomy(){ //Returns an array of product arrays. Failure returns NULL.
            // Function uses dynamic amount of arguments.
            // Gets products with Taxanomy matching arguments,
            // several arguments possible, need exact match.
            // Example: dbGetProductsFromTaxanomy(Taxanomy1,Taxanomy2...);

            $numargs=func_num_args();
            $arg_list=func_get_args();
            $product_list=NULL;
            $taxanomy_list=NULL;
            $complete_list=NULL;
            if($numargs==1 && $arg_list[0]=="ALL"){
                $result=$this->query("SELECT * FROM products");
                $tax_result=$this->query("SELECT * FROM taxanomies");
                $i=0;
                while($row=$result->fetch_assoc()){
                    $product_list[$i]=$row;
                    $i++;
                }
                $i=0;
                while($row=$tax_result->fetch_assoc()){
                    $taxanomy_list[$row['TaxanomyId']]=$row;
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
                $result= $this->query("SELECT * FROM products WHERE Taxanomy in ($param)");
                $i=0;
                while($row=$result->fetch_assoc()){
                    $product_list[$i]=$row;
                    $i++;
                }
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
                $result=$this->query("SELECT * FROM currencies");
                $i=0;
                while($row=$result->fetch_assoc()){
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
                $result=$this->query("SELECT * FROM currencies WHERE CurrencyId in ($param)");
                $i=0;
                while($row=$result->fetch_assoc()){
                    $currency_list[$i]=$row;
                    $i++;
                }
            }
            return $currency_list;
        }


        /*  ###################################################################################################
            Misc functions
        */  ###################################################################################################

        private function PasswordHash($salt,$password){ //Returns a string
            // Used for securing password in database
            $hash = $salt.$password;
            return hash("md5",$hash);
        }

        private function AddPasswordSalt(){
            $takefrom=array('1','2','3','4','5','6','7','8','9','0','a','b','c','d','e','f');
            $salt="";
            for($i=0;$i<21;$i++){
                $salt.=$takefrom[rand(0,count($takefrom)-1)];
            }
            return $salt;
        }

        private function dbGetUnixTime(){ // Returns current time and date
            date_default_timezone_set('Europe/Stockholm');
            return date('o-m-d H:i:s', time());
        }
    // END OF CLASS Database
    }
?>