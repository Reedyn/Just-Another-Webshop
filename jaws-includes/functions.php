<?php

    include_once 'class-product.php';
    include_once 'class-order.php';
    include_once 'class-user.php';
    include_once 'db.php';
    
    function jaws_header() {
        include($_SERVER['DOCUMENT_ROOT']."/jaws-content/header.php");
    }
    
    function jaws_footer() {
        include($_SERVER['DOCUMENT_ROOT']."/jaws-content/footer.php");
    }
    function jaws_navigation() {
        include($_SERVER['DOCUMENT_ROOT']."/jaws-content/navigation.php");
    }
    
    function showError($error, $type) {
        echo '<div class="alert alert-'.$type.'">';
        echo '    <a class="close" data-dismiss="alert">×</a>';
        echo '    <strong>'.$error.'</strong>.';
        echo '</div>';
    }
    
    function generatePassword($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);
    
        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }
    
        return $result;
    }
    function addToCart($productId) {
        if(isset($_SESSION['cart'][$productId])){
            $_SESSION['cart'][$productId] += 1;
        } else {
            $_SESSION['cart'][$productId] = 1;
        } 
    }
    
    function registerError($message, $type) {
        $_SESSION['error'] = array("message" => $message,"type" => $type);
    }
    
    function isAdmin() {
        if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true && isset($_SESSION['is-admin']) && $_SESSION['is-admin'] == true) {
            return true;
        }
        return false;    
    }
    
    function isLoggedIn() {
        if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) {
            return true;
        }
        return false;  
    }
    
    function loginPrompt($prompt){
        $_SESSION['redirect'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        registerError($prompt,'warning');
        header('Location: /login/');
        exit;
    }
    
    function itemsInCart(){
        if(isset($_SESSION['cart'])){
            $cartAmount = 0;
            $suffix = "item";
            foreach ($_SESSION['cart'] as $key => $value){
                $cartAmount += $value;
            }
            if($cartAmount != 1){
                $suffix = "items";
            }
            echo "<span>(".$cartAmount." ".$suffix.")</span>";
        }
    }

    function listProductsFromTaxanomy($TaxanomyId){
        $products=NULL;
        $products=getProductsFromTaxanomy($TaxanomyId);
        if($products){
            echo '<div class="row">';
            for($i=0;$i<count($products);$i++){
                echo '<div class="col-lg-4">
                        <img class="img-circle" src="'.$products[$i]->ImgUrl.'img/helmet.jpg" alt="Generic placeholder image">
                        <h2>'.$products[$i]->Name.'Helmets</h2>
                        <h3>'.$products[$i]->Price.'345$</h3>
                        <p>'.$products[$i]->Description.'</p>
                        <p>
                            <input type="button" class="btn btn-default" value="View details">
                            <input type="button" class="btn btn-primary" value="Add to cart">
                        </p>
                    </div><!-- /.col-lg-4 -->';
            }
            echo '</div>';
        }
    }
    function listSingleProduct($ProductId){
        $product=getProduct($ProductId);
        if($product){
            echo '<div class="row">

                    <div class="col-lg-2">
                      <img class="img-thumbnail" src="'.$product->ImgUrl.'" alt="Generic placeholder image">

                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-10">
                          <h2 class="zeroM">'.$product->Name.'</h2>
                          <h3>'.$product->Price.'$</h3>
                          <p class="pID">srNr: '.$product->ProductId.'</p>
                          <p>'.$product->Description.'</p>
                          <p class="pID">Weight: '.$product->ProductWeight.'kg</p>
                          <p>
                            <input type="button" class="btn btn-default" value="Back">
                            <input type="button" class="btn btn-primary" value="Add to cart">
                            (currently in stock: '.$product->Stock.')
                          </p>
                        </div>
                    </div>';
        }
    }
    function listCart(){

    }
    function listAdminSingleOrder($OrderId){
        $order=getOrder($OrderId);
        if($order){
            echo '<div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading ">Order</div>
        <div class="panel-body">
          <table class="table">
            <th>Invoice</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <tr>
              <td class="bold">Costumer</td>
              <td></td>
              <td class="bold">Gustav Lindqvist</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="bold">Ordernumber</td>
              <td></td>
              <td>'.$order->OrderId.'</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="bold">Date of purchase</td>
              <td></td>
              <td>'.$order->OrderDate.'</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="bold">Name</td>
              <td class="bold">Price</td>
              <td class="bold">Amount</td>
              <td class="bold">Reserved</td>
              <td class="bold">Sent</td>
              <td class="bold">Cost</td>
            </tr>';
            global $totalAmount;
            $totalAmount=0;
            for($i=0;$i<count($order->ProductList);$i++){
                echo '<tr>
                  <td>'.$order->ProductList[$i]->Name.'</td>
                  <td>'.$order->ProductList[$i]->ProductPrice.'$</td>
                  <td>'.$order->ProductList[$i]->Amount.'</td>
                  <td>0</td>
                  <td>'.$order->ProductList[$i]->Amount.'</td>
                  <td class="bold">'.($order->ProductList[$i]->Amount)*($order->ProductList[$i]->ProductPrice).'$</td>
                </tr>';
                $totalAmount+=($order->ProductList[$i]->Amount)*($order->ProductList[$i]->ProductPrice);
            }

            $shippingCost=20;
            echo '<tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="bold">Shipping cost</td>
              <td class="bold">'.$shippingCost.'$</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="bold">Total cost, including shipping etc..</td>
              <td class="bold">'.$totalAmount+=$shippingCost.'$</td>
            </tr>
          </table>
          <table>
            <tr>
              <td><input type="button" class="btn btn-default" value="Back"></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </table>
         </div>
        </div>';
        }
    }
    function listAdminOrders(){
        $orders=getAllOrders();
        echo '<div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading ">Database orders</div>
        <div class="panel-body">
          <table class="table">
            <th><input type="button" class="btn btn-default" value="Order ID"></th>
            <th><input type="button" class="btn btn-default" value="Date of purchase"></th>
            <th><input type="button" class="btn btn-default" value="Personal number"></th>
            <th><input type="button" class="btn btn-default" value="Total cost"></th>
            <th>Full details</th>';
        for($i=0;$i<count($orders);$i++){
            echo '<tr>
              <td>'.$orders[$i]->OrderId.'</td>
              <td>'.$orders[$i]->OrderDate.'</td>
              <td>'.$orders[$i]->SSNr.'</td>
              <td>'.$orders[$i]->OrderPrice.'$</td>
              <td><input type="button" class="btn btn-default" value="View"></td>
            </tr>';
        }
         echo '</table>
        </div>
      </div>';
    }

    function UserRegister(){
        global $db;
        if($db->dbAddUser($_POST['SSNr'],$_POST['email'],$_POST['password'],$_POST['firstName'],$_POST['lastName'],$_POST['streetAddress'],$_POST['postAddress'],$_POST['city'],$_POST['phone'])==TRUE){
            echo '<span class="reg_success">Registration successful</span>';
        }else{
            echo '<span class="reg_failed">Registration failed</span>';
        }
    }
    function UserLogin(){
        global $db;
        if($CurrentUser=$db->dbMatchPassword($_POST['email'],$_POST['password'])){
        //if($CurrentSSNr=$db->dbMatchPassword($a,$b)==TRUE){
            $chars=array('1','2','3','4','5','6','7','8','9','0','a','b','c','d','e','f');

            $sessionkey="";
            for($i=0;$i<21;$i++){
                $sessionkey.=$chars[rand(0,count($chars)-1)];
            }
            if($db->dbEditUser($CurrentUser[0],"SessionKey",$sessionkey)==TRUE){
                echo '<span class="login_success">Login successful</span>';
                $_SESSION['SessionKey']=$sessionkey;
                if($CurrentUser[1]==TRUE){
                    $_SESSION['IsAdmin']=TRUE;
                }
            }

        }else{
            echo '<span class="login_failed">Login failed</span>';
        }
    }
    // -------------------------------------
    //  USER START
    // -------------------------------------
    function getUser($SSNr) { // Returns a product from the product as a Product class.
        global $db;
        //Call function in db.php to get the array of users
        $data=$db->dbGetUser($SSNr);

        $user=NULL;
        if($data!=NULL){
            $user=new User($data['SSNr'],$data['Mail'],$data['Password'],$data['FirstName'],$data['LastName'],$data['StreetAddress'],$data['PostAddress'],$data['City'],$data['Telephone'],$data['SessionKey'],$data['IsAdmin']);
        }
        return $user;
    }

    function getAllUsers(){
        global $db;

        $data=$db->dbGetUsersAll();

        $users=NULL;
        for($i=0;$i<count($data);$i++){
            $users=new User($data[$i]['SSNr'],$data[$i]['Mail'],$data[$i]['Password'],$data[$i]['FirstName'],$data[$i]['LastName'],$data[$i]['StreetAddress'],$data[$i]['PostAddress'],$data[$i]['City'],$data[$i]['Telephone'],$data[$i]['SessionKey'],$data[$i]['IsAdmin']);
        }
        return $users;
    }
    // END USER ------------------------------------|

    // -------------------------------------
    //  PRODUCT
    // -------------------------------------
    function getProduct($ProductId) { // Returns a product from the product as a Product class.
        global $db;
        $data=$db->dbGetProduct($ProductId);
        $product=NULL;
        if($data!=NULL){
            $product=new Product($data['ProductId'],$data['Name'],$data['Description'],$data['ImgUrl'],$data['Taxanomy'],$data['Price'],$data['Stock'],$data['ProductWeight']);
        }
        return $product;
    }
    function getAllProducts(){
        global $db;
        $data=$db->dbGetProductsAll();
        $products=NULL;
        for($i=0;$i<count($data);$i++){
            $products[$i]=new Product($data[$i]['ProductId'],$data[$i]['Name'],$data[$i]['Description'],$data[$i]['ImgUrl'],$data[$i]['Taxanomy'],$data[$i]['Price'],$data[$i]['Stock'],$data[$i]['ProductWeight']);
        }
        return $products;
    }
    function getProductsFromTaxanomy($TaxanomyId){
        global $db;
        $data=$db->dbGetProductsFromTaxanomy($TaxanomyId);
        $products=NULL;
        for($i=0;$i<count($data);$i++){
            $products[$i]=new Product($data[$i]['ProductId'],$data[$i]['Name'],$data[$i]['Description'],$data[$i]['ImgUrl'],$data[$i]['Taxanomy'],$data[$i]['Price'],$data[$i]['Stock'],$data[$i]['ProductWeight']);
        }
        return $products;

    }

    // END PRODUCT ---------------------------------|


    // -------------------------------------
    //  ORDER
    // -------------------------------------
    function getOrder($OrderId) { // Returns an order from the order as an Order class.
        global $db;
        //Call function in db.php to get the array of users
        $data=$db->dbGetOrder($OrderId);

        $order=NULL;
        if($data!=NULL){
            $order=new Order($data['OrderId'],$data['SSNr'],$data['OrderDate'],$data['Discount'],$data['ChargedCard'],$data['OrderIP'],$data['ProductList']);
        }
        return $order;
    }
    function getAllOrders() { // Returns an order from the order as an Order class.
        global $db;
        $data=$db->dbGetOrdersAll();
        $orders=NULL;
        for($i=0;$i<count($data);$i++){
            $orders[$i]=new Order($data[$i]['OrderId'],$data[$i]['SSNr'],$data[$i]['OrderDate'],$data[$i]['Discount'],$data[$i]['ChargedCard'],$data[$i]['OrderIP'],NULL);
        }
        return $orders;
    }
    function getUsersOrders($SSNr) { // Returns an order from the order as an Order class.
        global $db;
        $data=$db->dbGetUsersOrders($SSNr);
        $orders=NULL;
        for($i=0;$i<count($data);$i++){
            $orders[$i]=new Order($data[$i]['OrderId'],$data[$i]['SSNr'],$data[$i]['OrderDate'],$data[$i]['Discount'],$data[$i]['ChargedCard'],$data[$i]['OrderIP'],NULL);
        }
        return $orders;
    }
    // END ORDER ----------------------------------|

?>