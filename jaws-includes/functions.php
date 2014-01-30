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
    function fillForm($form, $name) {
        if(isset($_SESSION['form'][$form])){ 
            echo 'value="'.$_SESSION['form'][$form][$name].'"';
        }
    }
    
    function addToCart($productId) {
        if(isset($_SESSION['cart']['items'][$productId])){
            $_SESSION['cart']['items'][$productId] += 1;
        } else {
            $_SESSION['cart']['items'][$productId] = 1;
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
        $_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
        registerError($prompt,'warning');
        header('Location: /login/');
        exit;
    }
    function redirect($location){
        header("Location: ".$location);
        exit();
    }
    
    function setCurrency($id,$name,$sign,$position,$multiplier) {
        $_SESSION['currency']['multiplier'] = $multiplier;
        $_SESSION['currency']['name'] = $name;
        $_SESSION['currency']['sign'] = $sign;
        $_SESSION['currency']['id'] = $id;
        $_SESSION['currency']['position'] = $position;
    }
    
    function showCurrency($value){
        if(isset($_SESSION['currency']['position']) && $_SESSION['currency']['position'] != "suffix"){
            return $_SESSION['currency']['sign'].$value*$_SESSION['currency']['multiplier'];
        } else {
            return $value*$_SESSION['currency']['multiplier']." ".$_SESSION['currency']['sign'];
        }
    }
    
    function itemsInCart(){
        if(isset($_SESSION['cart']['items'])){
            $cartAmount = 0;
            $suffix = "item";
            foreach ($_SESSION['cart']['items'] as $key => $value){
                $cartAmount += $value;
            }
            
            if($cartAmount != 1){
                $suffix = "items";
            }
            if($cartAmount == 0){
                echo "";
            } else {
                echo "<span>(".$cartAmount." ".$suffix.")</span>";
            }
            
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
          <table class="sortable table">
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
        <div class="panel-heading ">Orders</div>
        <div class="panel-body">
          <table id="sortable" class="table">
            <thead>
            <th><input type="button" class="sort btn btn-default" data-sort="order-id" value="Order ID"></th>
            <th><input type="button" class="sort btn btn-default" data-sort="order-date" value="Date of purchase"></th>
            <th><input type="button" class="sort btn btn-default" data-sort="order-ssnr" value="Personal number"></th>
            <th><input type="button" class="sort btn btn-default" data-sort="order-value" value="Total value"></th>
            <th><input placeholder="Search.." class="form-control search" /></th>
            </thead><tbody class="list">';
        if($orders){
            for($i=0;$i<count($orders);$i++){
                echo '<tr>
                  <td class="order-id">'.$orders[$i]->OrderId.'</td>
                  <td class="order-date">'.$orders[$i]->OrderDate.'</td>
                  <td class="order-ssnr">'.$orders[$i]->SSNr.'</td>
                  <td class="order-value">'.showCurrency($orders[$i]->OrderPrice).'</td>
                  <td><a href="/admin/orders/'.$orders[$i]->OrderId.'/" class="btn btn-default">Edit</a></td>
                </tr>';
            }
        }
        echo '</tbody></table>
            </div>
        </div>
        <script>
            var options = {
            valueNames: [ "order-id", "order-ssnr", "order-date", "order-value" ]
            };
        
            var sortable = new List("sortable", options);
        </script>';
    }
    function listAdminSingleProduct($ProductId){
        if ($ProductId == "new"){
            echo '<div class="panel panel-primary">
        <div class="panel-heading ">New Product</div>
        <div class="panel-body">
          <form method="post" enctype="multipart/form-data" class="form-signin" role="form">
            Name
            <input pattern="^.+$"name="product-name" type="text" class="form-control">
            description
            <textarea pattern="^.+$" name="product-description" type="text" id="mBot" rows="10" class="form-control"></textarea>
            <div class="row">
              <div class="col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon">Product ID</span>
                  <input pattern="^\d+$" disabled name="product-id" type="text" class="form-control" placeholder="Will be automatically generated">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon">Price (in Euro)</span>
                  <input name="product-price" type="text" pattern="^\d+$" class="form-control">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon">Currently in stock</span>
                  <input pattern="^\d+$" name="product-stock" type="text" class="form-control">
                </div>
              </div>
              <div class="col-lg-4">
               <div class="input-group">
                <span class="input-group-addon">Weight (in gram)</span>
                <input pattern="^\d+$" name="product-weight" type="text" class="form-control">
              </div>
            </div>
              <div class="col-lg-4">
               <div class="input-group">
                <span class="input-group-addon">Category</span>
                <select class="form-control" name="product-category">
                  <option value="false">None</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </div>
              <div class="col-lg-4">
                <span class="btn btn-block btn-default btn-file">Browse image<input name="product-image" required data-message="You need to upload an image" accept="image/jpeg" type="file">
                </span>
              </div>
          </div>
        <div class="row">
              <div class="col-lg-4">
              </div>
              <div class="col-lg-8">
              <button name="product-add" class="btn btn-primary btn-block" type="submit">Add product</button>
              </div>
            </div>
        </form>
      </div>
    </div>';
        } else {
            $product=getProduct($ProductId);
            if($product){
                echo '<div class="panel panel-primary">
        <div class="panel-heading ">New Product</div>
        <div class="panel-body">
          <form method="post" enctype="multipart/form-data" class="form-signin" role="form">
            Name
            <input pattern="^.+$"name="product-name" type="text" class="form-control" value="'.$product->Name.'">
            description
            <textarea pattern="^.+$" name="product-description" type="text" id="mBot" rows="10" class="form-control">'.$product->Description.'</textarea>
            <div class="row">
              <div class="col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon">Product ID</span>
                  <input pattern="^\d+$" readonly name="product-id" type="text" class="form-control" value="'.$product->ProductId.'">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon">Price (in Euro)</span>
                  <input name="product-price" type="text" pattern="^\d+$" class="form-control" value="'.$product->Price.'">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon">Currently in stock</span>
                  <input pattern="^\d+$" name="product-stock" type="text" class="form-control" value="'.$product->Stock.'">
                </div>
              </div>
              <div class="col-lg-4">
               <div class="input-group">
                <span class="input-group-addon">Weight (in gram)</span>
                <input pattern="^\d+$" name="product-weight" type="text" class="form-control" value="'.$product->ProductWeight.'">
              </div>
            </div>
              <div class="col-lg-4">
               <div class="input-group">
                <span class="input-group-addon">Category</span>
                <select class="form-control" name="product-category" value="'.$product->Taxanomy.'">
                  <option value="false">None</option>
                  <option>2</option>
                  <option selected>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </div>
              <div class="col-lg-4">
                <span class="btn btn-block btn-default btn-file">Browse image<input name="product-image" data-message="You need to upload an image" accept="image/jpeg" type="file">
                </span>
              </div>
          </div>
        <div class="row">
              <div class="col-lg-4">
              <button name="product-delete" class="btn btn-danger btn-block" type="submit">Delete product</button>
              </div>
              <div class="col-lg-8">
              <button name="product-edit" class="btn btn-primary btn-block" type="submit">Save product</button>
              </div>
            </div>
        </form>
      </div>
    </div>';
            }else{
                showError('No product found','danger');
            }
        } 
    }

    function listAdminProducts(){
        $products=getAllProducts();
        echo '<div class="panel panel-primary">
            <div class="panel-heading ">Products</div>
            <div class="panel-body">
            <table id="sortable" class="table">
            <thead>
            <th><input data-sort="product-name" type="button" class="sort btn btn-default" value="Name"></th>
            <th><input data-sort="product-id"type="button" class="sort btn btn-default" value="Product ID"></th>
            <th><input data-sort="product-value"type="button" class="sort btn btn-default" value="Price"></th>
            <th><input data-sort="product-category"type="button" class="sort btn btn-default" value="Category"></th>
            <th><input placeholder="Search.." class="form-control search" /></th>
            </thead><tbody class="list">';
        if($products){
            for($i=0;$i<count($products);$i++){
                echo '<tr>
              <td class="product-name">'.$products[$i]->Name.'</td>
              <td class="product-id">'.$products[$i]->ProductId.'</td>
              <td class="product-value">'.$products[$i]->Price.'</td>
              <td class="product-category">'.$products[$i]->Taxanomy.'</td>
              <td><a href="/admin/products/'.$products[$i]->ProductId.'/" class="btn btn-default">Edit</a></td>
            </tr>';
            }

        }
        echo '</tbody><tfoot><tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>
                <a href="/admin/products/new/" class="btn btn-primary">Add Product</a>
              </td>
            </tr></tfoot>
            </table>
            </div></div>
            <script>
            var options = {
            valueNames: [ "product-id", "product-name", "product-category", "product-value" ]
            };
        
            var sortable = new List("sortable", options);
            </script>';
    }
    function listAdminSingleUser($SSNr){
        $user=getUser($SSNr);
        if($user){
            echo '<div class="well well-lg">
            <h2 class="form-signin-heading">Edit Profile</h2>
            <form class="form-signin" role="form">
              <div class="row">
                <div class="col-lg-4">
                  <div class="input-group">
                    <span class="input-group-addon inputLeft">Social Security Number</span>
                    <input type="text" class="form-control" value="'.$user->SSNr.'" readonly>
                  </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-4">
                  <div class="input-group">
                    <span class="input-group-addon inputLeft">First name</span>
                    <input type="text" class="form-control" value="'.$user->FirstName.'">
                  </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-4">
                  <div class="input-group">
                    <span class="input-group-addon inputLeft">Last Name</span>
                    <input type="text" class="form-control" value="'.$user->LastName.'">
                  </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
              </div><!-- /.row -->
              <div class="row">
                <div class="col-lg-4">
                  <div class="input-group">
                    <span class="input-group-addon inputLeft">Street Address</span>
                    <input type="text" class="form-control" value="'.$user->StreetAddress.'">
                  </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-4">
                  <div class="input-group">
                    <span class="input-group-addon inputLeft">Post Address</span>
                    <input type="text" class="form-control" value="'.$user->PostAddress.'">
                  </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-4">
                  <div class="input-group">
                    <span class="input-group-addon inputLeft">City</span>
                    <input type="text" class="form-control" value="'.$user->City.'">
                  </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
              </div><!-- /.row -->
              <div class="row">
                <div class="col-lg-4">
                  <div class="input-group">
                    <span class="input-group-addon inputLeft">Phone</span>
                    <input type="text" class="form-control" value="'.$user->Telephone.'">
                  </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->

              </div><!-- /.row -->

              <div class="row">
                <div class="col-lg-4">
                  <div class="input-group">
                    <input type="button" class="btn btn-primary" value="New password">
                  </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->

              </div><!-- /.row -->

              <div class="row">
                <div class="col-lg-4">
                  <button class="btn btn-primary btn-block" type="submit">Submit changes</button>
                </div>
              </div>
            </form>
          </div>';
        }else{
            echo 'No user found!';
        }
    }
    function listAdminUsers(){
        $users=getAllUsers();
        echo'<div class="panel panel-primary">
              <!-- Default panel contents -->
              <div class="panel-heading ">Users</div>
              <div class="panel-body">
                  <table id="sortable" class="table">
                      <thead>
                      <th><input data-sort="user-ssnr" type="button" class="sort btn btn-default" value="Personal Securit Number"></th>
                      <th><input data-sort="user-name" type="button" class="sort btn btn-default" value="Full name"></th>
                      <th><input placeholder="Search.." class="form-control search" /></th></thead><tbody class="list">';
        if($users){

            for($i=0;$i<count($users);$i++){
                echo '<tr>
                          <td class="user-ssnr">'.$users[$i]->SSNr.'</td>
                          <td class="user-name">'.$users[$i]->FirstName.' '.$users[$i]->LastName.'</td>
                          <td><a href="/admin/users/'.$users[$i]->SSNr.'/" class="btn btn-default">Edit</a></td>
                      </tr>';
            }
        }
        echo '</tbody><tfoot><tr>
              <td></td>
              <td></td>
              <td><a href="/admin/users/new/" class="btn btn-primary">Add User</a></td>
            </tr></tfoot>
          </table>

        </div>

      </div>
      <script>
            var options = {
            valueNames: [ "user-ssnr", "user-name" ]
            };
        
            var sortable = new List("sortable", options);
        </script>';
    }
    function listAdminTaxanomies(){
        $GLOBALS['db']->dbGetTaxanomyAll();
    }

    function UserRegister(){
        if($GLOBALS['db']->dbAddUser($_POST['SSNr'],$_POST['email'],$_POST['password'],$_POST['firstName'],$_POST['lastName'],$_POST['streetAddress'],$_POST['postAddress'],$_POST['city'],$_POST['phone'])==TRUE){
            echo '<span class="reg_success">Registration successful</span>';
        }else{
            echo '<span class="reg_failed">Registration failed</span>';
        }
    }
    function UserLogin($mail,$password){
        if($CurrentUser=$GLOBALS['db']->dbMatchPassword($mail,$password)){
            $chars=array('1','2','3','4','5','6','7','8','9','0','a','b','c','d','e','f');

            $sessionkey="";
            for($i=0;$i<21;$i++){
                $sessionkey.=$chars[rand(0,count($chars)-1)];
            }
            if($GLOBALS['db']->dbEditUser($CurrentUser[0],"SessionKey",$sessionkey)==TRUE){
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
        //Call function in db.php to get the array of users
        $data=$GLOBALS['db']->dbGetUser($SSNr);

        $user=NULL;
        if($data!=NULL){
            $user=new User($data['SSNr'],$data['Mail'],$data['Password'],$data['FirstName'],$data['LastName'],$data['StreetAddress'],$data['PostAddress'],$data['City'],$data['Telephone'],$data['SessionKey'],$data['IsAdmin']);
        }
        return $user;
    }

    function getAllUsers(){

        $data=$GLOBALS['db']->dbGetUsersAll();

        $users=NULL;
        for($i=0;$i<count($data);$i++){
            $users[$i]=new User($data[$i]['SSNr'],$data[$i]['Mail'],$data[$i]['Password'],$data[$i]['FirstName'],$data[$i]['LastName'],$data[$i]['StreetAddress'],$data[$i]['PostAddress'],$data[$i]['City'],$data[$i]['Telephone'],$data[$i]['SessionKey'],$data[$i]['IsAdmin']);
        }
        return $users;
    }
    // END USER ------------------------------------|

    // -------------------------------------
    //  PRODUCT
    // -------------------------------------
    function getProduct($ProductId) { // Returns a product from the product as a Product class.
        $data=$GLOBALS['db']->dbGetProduct($ProductId);
        $product=NULL;
        if($data!=NULL){
            $product=new Product($data['ProductId'],$data['Name'],$data['Description'],$data['ImgUrl'],$data['Taxanomy'],$data['Price'],$data['Stock'],$data['ProductWeight']);
        }
        return $product;
    }
    function getAllProducts(){
        $data=$GLOBALS['db']->dbGetProductsAll();
        $products=NULL;
        for($i=0;$i<count($data);$i++){
            $products[$i]=new Product($data[$i]['ProductId'],$data[$i]['Name'],$data[$i]['Description'],$data[$i]['ImgUrl'],$data[$i]['Taxanomy'],$data[$i]['Price'],$data[$i]['Stock'],$data[$i]['ProductWeight']);
        }
        return $products;
    }
    function getProductsFromTaxanomy($TaxanomyId){
        $data=$GLOBALS['db']->dbGetProductsFromTaxanomy($TaxanomyId);
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
        $data=$GLOBALS['db']->dbGetOrder($OrderId);

        $order=NULL;
        if($data!=NULL){
            $order=new Order($data['OrderId'],$data['SSNr'],$data['OrderDate'],$data['Discount'],$data['ChargedCard'],$data['OrderIP'],$data['ProductList']);
        }
        return $order;
    }
    function getAllOrders() { // Returns an order from the order as an Order class.
        $data=$GLOBALS['db']->dbGetOrdersAll();
        $orders=NULL;
        for($i=0;$i<count($data);$i++){
            $orders[$i]=new Order($data[$i]['OrderId'],$data[$i]['SSNr'],$data[$i]['OrderDate'],$data[$i]['Discount'],$data[$i]['ChargedCard'],$data[$i]['OrderIP'],NULL);
        }
        return $orders;
    }
    function getUsersOrders($SSNr) { // Returns an order from the order as an Order class.
        $data=$GLOBALS['db']->dbGetUsersOrders($SSNr);
        $orders=NULL;
        for($i=0;$i<count($data);$i++){
            $orders[$i]=new Order($data[$i]['OrderId'],$data[$i]['SSNr'],$data[$i]['OrderDate'],$data[$i]['Discount'],$data[$i]['ChargedCard'],$data[$i]['OrderIP'],NULL);
        }
        return $orders;
    }
    // END ORDER ----------------------------------|
?>