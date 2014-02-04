<?php
    include_once 'config.php';
    global $db;
    $db=new Database($config['dbHost'],$config['dbUser'],$config['dbPassword'],$config['dbName']);

    class Database extends mysqli {
        public function __construct($dbHost,$dbUser,$dbPassword,$dbName) {
            parent::__construct($dbHost,$dbUser,$dbPassword,$dbName);
        }

        /*  ###################################################################################################
            Users
        */  ###################################################################################################

        public function dbAddUser($SSNr,$Mail,$Password,$FirstName,$LastName,$StreetAddress,$PostAddress,$City,$Telephone,$IsAdmin = 0) { // Attempts to add a user and returns a boolean.
            // Adds one user to the users table.
            // Arguments states what needs to be
            // put in.
            $salt=$this->AddPasswordSalt();

            $hashedPassword=$this->PasswordHash($salt,$Password);
            if ($this->query("INSERT INTO users (SSNr,Mail,Password,FirstName,LastName,StreetAddress,PostAddress,City,Telephone,IsAdmin,PwSalt) VALUES ('$SSNr','$Mail','$hashedPassword','$FirstName','$LastName','$StreetAddress','$PostAddress','$City','$Telephone','$IsAdmin','$salt')")) {
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
            if($this->query("UPDATE users SET $param WHERE SSNr='$SSNr'")==TRUE){
                return true;
            }else{
                return false;
            }
        }

        public function dbDeleteUser($SSNr) { // Attempts to delete users and returns a boolean.
            if($this->query("DELETE FROM users WHERE SSNr in ($SSNr)")==TRUE){
                return true;
            }else{
                return false;
            }
        }

        public function dbGetUser($SSNr){ //Returns an array with user arrays, NULL/FALSE if none found.
            $user=NULL;
            if($result=$this->query("SELECT * FROM users WHERE SSNr in ($SSNr)")){
                while($row=$result->fetch_assoc()){
                    $user=$row;
                }    
            }
            return $user;
        }

        public function dbGetUsersAll(){
            $user_list=NULL;
            if($result=$this->query("SELECT * FROM users")){
                $i=0;
                while($row=$result->fetch_assoc()){
                    $user_list[$i]=$row;
                    $i++;
                }    
            }
            return $user_list;
        }

        public function dbGetUsersOrders($SSNr){
            $order_list=NULL;
            if($result=$this->query("SELECT * FROM orders WHERE SSNr in ($SSNr)")){
                $i=0;
                while($row=$result->fetch_assoc()){
                    $order_list[$i]=$row;
                    $i++;
                }
            }
            return $order_list;
        }

        /*  ###################################################################################################
            Login
        */  ###################################################################################################


        public function dbMatchPassword($LoginEmail, $LoginPassword) {// Used to check if login matches database, returns a boolean.
            if($result=$this->query("SELECT SSNr,Mail,Password,PwSalt,IsAdmin FROM users WHERE Mail='$LoginEmail'")){
                $row=$result->fetch_assoc();
            }else{
                return false;
            }
            $hashedPassword=$this->PasswordHash($row['PwSalt'],$LoginPassword);
            if ($row != NULL) {
                if ($LoginEmail==$row['Mail'] && $hashedPassword==$row['Password']) {
                    //Return the SSNr may be necessary
                    $retarr=array($row['SSNr'],$row['IsAdmin']);
					return $retarr;
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
        
        public function dbMatchSessionKey($SSNr, $SessionKey){
            if($result=$this->query("SELECT SessionKey,IsAdmin FROM users WHERE SSNr='$SSNr'")){
                return $result->fetch_assoc();
            }else{
                return false;
            }
        }
        
        public function setResetKey($Mail,$ResetKey){
            if($this->query("UPDATE users SET ResetKey='$ResetKey' WHERE Mail='$Mail'")){
                return true;
            } else {
                return false;
            }
        }
        
        public function getResetKey($ResetKey){
            if($result=$this->query("SELECT ResetKey,SSNr FROM users WHERE ResetKey='$ResetKey'")){
                return $result->fetch_assoc();
            }else{
                return false;
            }
        }

        /*  ###################################################################################################
            Cards
        */  ###################################################################################################

        public function dbAddCard($CardNr,$CardName,$ExpiryMonth,$ExpiryYear) { // Attempts to add a card, returns a boolean.
            // Adds one card to the cards table.
            // Arguments states what needs to be
            // put in.
             if ($this->query("INSERT INTO cards SET CardNr='$CardNr',CardName='$CardName',ExpiryMonth='$ExpiryMonth', ExpiryYear='$ExpiryYear'")) {
                 return $this->insert_id;
             }else{
                return false;
            }
        }

        public function dbDeleteCard($CardId) { // Attempts to remove a card, returns a boolean.
            if($this->query("DELETE FROM cards WHERE CardId in ($CardId)")){
                return true;
            }else{
                return false;
            }
        }

        public function dbGetCard($CardId){ //Attempts to get cards, returns an array with card arrays. If failure returns NULL.
            $card=NULL;
            if($result=$this->query("SELECT * FROM cards WHERE CardId in($CardId)")){
                $card=$result->fetch_assoc();
            }
            return $card;
        }

        public function dbGetCardsAll(){
            $card_list=NULL;
            if($result=$this->query("SELECT * FROM cards")){
                $i=0;
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

        public function dbAddOrder($SSNr,$Discount,$ChargedCard) { // Attempts to add an order to the database, returns a boolean.
            // Function arguments have dynamic amount, meaning
            // the first argument is the ID for User (SSNr),
            // the second is discount (Discount) and third is the id for
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
            $OrderIP = $_SERVER['REMOTE_ADDR'];
            $this->autocommit(false);
            if($this->query("INSERT INTO orders SET SSNr='$SSNr', OrderDate='$time',Discount='$Discount',ChargedCard='$ChargedCard',OrderIP='$OrderIP'")){
                $j=0;
                $param[$j]=$this->insert_id;
                $j++;
                for($i=4;$i<$numargs;$i++){
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
            // This wont be called from outside of this class

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
            if($this->query("INSERT INTO order_lists (OrderId,ProductId,Amount) VALUES $param")){
                return true;
            }else{
               return false;
            }
        }
        
        public function dbAddOrder2($ChargedCard,$SSNr,$OrderIP,$ShippingCost,$OrderList){
            $time=$this->dbGetUnixTime();
            $this->autocommit(false);
            $status=0;
            if($this->dbAddCard($ChargedCard['nr'],$ChargedCard['fullname'],$ChargedCard['expmonth'],$ChargedCard['expyear'])){
                $status=1;
                $CardId=$this->insert_id;
                if($this->query("INSERT INTO orders SET SSNr='$SSNr', ShippingCost='$ShippingCost', OrderDate='$time',OrderIP='$OrderIP',ChargedCard='$CardId'")){
                    $status=2;
                    $OrderId=$this->insert_id;
                    if($orderTotal=$this->dbAddOrderList2($OrderId,$OrderList)){
                        $status=3;
                        $this->dbEditOrder($OrderId,'OrderTotal',$orderTotal);
                        $this->commit();

                    }
                }
            }
            if($status!=3){
                $this->rollback();
            }
            $this->autocommit(TRUE);
            return $status;
        }
        private function dbAddOrderList2($OrderId,$OrderList){
            $param="";
            $i=0;
            $listLength=count($OrderList);
            $orderListTotal=0;
            foreach($OrderList as $id => $amount){
                $product=$this->dbGetProduct($id);
                $orderListPrice=$product['Price']*$amount;
                $param.="($OrderId,$id,$amount,$orderListPrice)";
                if($i!=($listLength-1)){
                    $param.=",";
                }

                $orderListTotal+=$product['Price']*$amount;
                $i++;
            }
            if($this->query("INSERT INTO order_lists (OrderId,ProductId,Amount,OrderListTotal) VALUES $param")){
                return $orderListTotal;
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
            if($this->query("UPDATE orders SET $param WHERE OrderId='$OrderId'")){
                return true;
            }else{
                return false;
            }
        }

        public function dbDeleteOrder($OrderId) { // Attempts to removes an order and associated ordered items (orderList), returns a boolean.
            
            $this->autocommit(false);
            if($this->query("DELETE FROM order_lists WHERE OrderId in ($OrderId)")){
                if($this->query("DELETE FROM orders WHERE OrderId in ($OrderId)")){
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

        public function dbGetOrder($OrderId){ //Attempts to get orders, returns an array with order arrays. If failure returns NULL.

            $order=NULL;
            if($result=$this->query("SELECT * FROM orders WHERE OrderId='$OrderId'")){
                if($result_list=$this->query("SELECT * FROM order_lists WHERE OrderId='$OrderId'")){
                    $order=$result->fetch_assoc();
                    $i=0;
                    while($row=$result_list->fetch_assoc()){
                        $order["OrderList"][$i]=$row;
                        $i++;
                    }
                }
            }
            return $order;

        }

        public function dbGetOrdersAll(){
            $order_list=NULL;
            if($result=$this->query("SELECT * FROM orders")){
                $i=0;
                while($row=$result->fetch_assoc()){
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
            $result=$this->query("SELECT * FROM products WHERE Name,Description LIKE '%$SearchQuery%'");
            $search_list=NULL;
            $i=0;
            while($row=$result->fetch_assoc()){
                $search_list[$i]=$row;
                $i++;
            }
            return $search_list;
        }

        public function dbAddProduct($Name,$Description,$ImgUrl,$Taxanomy,$Price,$Stock,$ProductWeight) { //Attempts to add a product, returns a boolean.
            // Adds one product to the products table.
            // Arguments states what needs to be
            // put in.
            if($this->query("INSERT INTO products SET Name='$Name',Description='$Description',ImgUrl='$ImgUrl',Taxanomy='$Taxanomy',Price='$Price',Stock='$Stock',ProductWeight='$ProductWeight'")){
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
            if($this->query("UPDATE products SET $param WHERE ProductId='$ProductId'")){
                return true;
            }else{
                return false;
            }
        }

        public function dbDeleteProduct($ProductId) { // Attempts to delete products, returns a boolean.
            if($this->query("DELETE FROM products WHERE ProductId in ($ProductId)")){
                return true;
            }else{
                return false;
            }
        }

        public function dbGetProduct($ProductId){ // Attempts to get product, returns a product array. Failure returns NULL.

            $product=NULL;
            
            if($result=$this->query("SELECT * FROM products WHERE ProductId in ($ProductId)")){
                $product=$result->fetch_assoc();
            }
            return $product;
        }

        public function dbGetProductsAll(){
            $product_list=NULL;
            
            if($result=$this->query("SELECT * FROM products WHERE ProductId")){
                $i=0;
                while($row=$result->fetch_assoc()){
                    $product_list[$i]=$row;
                    $i++;
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
            if($this->query("INSERT INTO taxanomies SET TaxanomyName='$TaxanomyName',TaxanomyParent='$TaxanomyParent'")){
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
            if($this->query("UPDATE taxanomies SET $param WHERE TaxanomyId='$TaxanomyId'")){
                return true;
            }else{
                return false;
            }
        }

        public function dbDeleteTaxanomy($TaxanomyId) { // Attempts to delete taxanomies, returns a boolean.
                
            if($this->query("DELETE FROM taxanomies WHERE TaxanomyId in ($TaxanomyId)")){
                return true;
            }else{
                return false;
            }
        }

        public function dbGetTaxanomy($TaxanomyId){//Returns an array with taxanomies
            $taxanomy=NULL;
            $result=$this->query("SELECT * FROM taxanomies WHERE TaxanomyId in ($TaxanomyId)");
            $taxanomy=$result->fetch_assoc();
            return $taxanomy;
        }

        public function dbGetProductsFromTaxanomy($TaxanomyId){ //Returns an array of product arrays. Failure returns NULL.
            
            $product_list=NULL;

            $result=$this->query("SELECT * FROM products WHERE Taxanomy in ($TaxanomyId)");
            $i=0;
            while($row=$result->fetch_assoc()){
                $product_list[$i]=$row;
                $i++;
            }
            return $product_list;
        }
        public function dbGetTaxanomiesAll(){ //Returns an array of product arrays. Failure returns NULL.

            $taxanomy_list=NULL;

            if($result=$this->query("SELECT * FROM taxanomies")){
                $i=0;
                while($row=$result->fetch_assoc()){
                    $taxanomy_list[$i]=$row;
                    $i++;
                }
            }
            return $taxanomy_list;
        }

        /*  ###################################################################################################
            Currency
        */  ###################################################################################################
        
        public function dbAddCurrency($CurrencyName,$CurrencyMultiplier,$CurrencySign,$CurrencyLayout) { //Attempts to add a currency, returns a boolean.
            // Adds one currency to the table.
            // Arguments states what needs to be
            // put in.
            if($this->query("INSERT INTO currencies SET CurrencyName='$CurrencyName',CurrencyMultiplier='$CurrencyMultiplier',CurrencySign='$CurrencySign',CurrencyLayout='$CurrencyLayout'")){
                return true;
            }else{
                return false;
            }
        }
        
        public function dbEditCurrency($CurrencyId) { //Attempts to edit a currency and returns a boolean.
            // Function arguments are dynamic meaning
            // the first argument is the ID for currency (CurrencyId).
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
            if($this->query("UPDATE currencies SET $param WHERE CurrencyId='$CurrencyId'")){
                return true;
            }else{
                return false;
            }
        }
        
        public function dbDeleteCurrency($CurrencyId) { // Attempts to delete currency, returns a boolean.              
            if($this->query("DELETE FROM currencies WHERE CurrencyId in ($CurrencyId)")){
                return true;
            }else{
                return false;
            }
        }

        public function dbGetCurrency($CurrencyId){ // Attempts to get currencies, returns an array of currency arrays. NULL if failure
            $currency=NULL;
            if($result=$this->query("SELECT * FROM currencies WHERE CurrencyId in ($CurrencyId)")){
                $currency=$result->fetch_assoc();    
            }
            return $currency;
        }
        public function dbGetCurrenciesAll(){
            $currency_list=NULL;
            if($result=$this->query("SELECT * FROM currencies")){
                $i=0;
                while($row=$result->fetch_assoc()){
                    $currency_list[$i]=$row;
                    $i++;
                }
            }
            return $currency_list;
        }
        
        /*  ###################################################################################################
            Shipping
        */  ###################################################################################################

        public function dbAddShipping($MaxWeight,$Price) { //Attempts to add a currency, returns a boolean.
            // Adds one product to the products table.
            // Arguments states what needs to be
            // put in.
            if($this->query("INSERT INTO shipping SET MaxWeight='$MaxWeight',Price='$Price'")){
                return true;
            }else{
                return false;
            }
        }
        
        public function dbEditShipping($MaxWeight) { //Attempts to edit a currency and returns a boolean.
            // Function arguments are dynamic meaning
            // the first argument is the ID for currency (CurrencyId).
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
            if($this->query("UPDATE shipping SET $param WHERE MaxWeight='$MaxWeight'")){
                return true;
            }else{
                return false;
            }
        }
        
        public function dbDeleteShipping($MaxWeight) { // Attempts to delete currency, returns a boolean.              
            if($this->query("DELETE FROM shipping WHERE MaxWeight in ($MaxWeight)")){
                return true;
            }else{
                return false;
            }
        }
        
        public function dbGetShipping($MaxWeight){ // Attempts to get currencies, returns an array of currency arrays. NULL if failure
            $shipping=NULL;
            if($result=$this->query("SELECT * FROM shipping WHERE MaxWeight in ($MaxWeight)")){
                $shipping=$result->fetch_assoc();    
            }
            return $shipping;
        }
        public function dbGetShippingAll(){
            $shipping_list=NULL;
            if($result=$this->query("SELECT * FROM shipping")){
                $i=0;
                while($row=$result->fetch_assoc()){
                    $shipping_list[$i]=$row;
                    $i++;
                }
            }
            return $shipping_list;
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