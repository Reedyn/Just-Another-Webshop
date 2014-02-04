<?php

    include_once 'class-product.php';
    include_once 'class-order.php';
    include_once 'class-user.php';
    include_once 'class-taxanomy.php';
    include_once 'class-currency.php';
    include_once 'db.php';

    function includeHeader() { // Shows the header
        include($_SERVER['DOCUMENT_ROOT']."/content/header.php");
    }
    
    function includeFooter() { // Shows the footer
        include($_SERVER['DOCUMENT_ROOT']."/content/footer.php");
    }
    function includeNavigation() { // Shows the navigation bar
        include($_SERVER['DOCUMENT_ROOT']."/content/navigation.php");
    }
    
    function showError($error, $type = "danger") { // Shows an error
        echo '<div class="alert alert-'.$type.'">';
        echo '    <a class="close" data-dismiss="alert">×</a>';
        echo '    <strong>'.$error.'</strong>.';
        echo '</div>';
    }
    
    function toAscii($str, $replace=array(), $delimiter='-') {
        if( !empty($replace) ) {
            $str = str_replace((array)$replace, ' ', $str);
        }
    
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
    
        return $clean;
    }
    
    function calculateShippingCost(){
        if(isset($_SESSION['cart']['items'])){
            $totalWeight = 0;
            foreach ($_SESSION['cart']['items'] as $key => $value){
                if(isset($value['amount']) && isset($value['weight'])){
                    $totalWeight += ($value['amount']*$value['weight']);
                }
            }
            $shipping;
            foreach ($GLOBALS['db']->dbGetShippingAll() as $key => $value){
                $shipping[$value['MaxWeight']] = $value['Price'];
            }
            ksort($shipping);
            $i = count($shipping);
            foreach ($shipping as $key => $value){
                if($key >= $totalWeight || $last_iteration = !(--$i)){
                    $_SESSION['cart']['shipping-cost'] = $value;
                    return $value;
                }
            }            
        }
    }
    
    function generatePassword($length = 8) { // Generates a secure password
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);
    
        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }
    
        return $result;
    }
    function fillForm($form, $name) { // Fill out the form with the specified value (if it exists)
        if(isset($_SESSION['form'][$form]) & isset($_SESSION['form'][$form][$name])){ 
            return $_SESSION['form'][$form][$name];
        }
    }
    
    function addToCart($productId) {
        if(isset($_SESSION['cart']['items'][$productId])){
            $_SESSION['cart']['items'][$productId]['amount'] += 1;
        } else {
            $_SESSION['cart']['items'][$productId]['amount'] = 1;
        } 
    }
    
    function registerError($message, $type = "danger") {
        $_SESSION['error'] = array("message" => $message,"type" => $type);
    }
    
    function isAdmin() {
        if (isset($_SESSION['LoginSSNr']) && isset($_SESSION['LoginSSNr'])){
            try {
                $array = $GLOBALS['db']->dbMatchSessionKey($_SESSION['LoginSSNr'],$_SESSION['SessionKey']);
            } catch (Exception $ex) {
                //
            } if($array['SessionKey'] == $_SESSION['SessionKey'] && $array['IsAdmin'] == 1) {
                return true;
            }
        }
        return false;  
    }
    
    function isLoggedIn() {
        if (isset($_SESSION['LoginSSNr']) && isset($_SESSION['LoginSSNr'])){
            try {
                $array = $GLOBALS['db']->dbMatchSessionKey($_SESSION['LoginSSNr'],$_SESSION['SessionKey']);
            } catch (Exception $ex) {
                //
            }
                
            if($array['SessionKey'] == $_SESSION['SessionKey']) {
                return true;
            }
        }
        return false;  
    }
    function loginPrompt($prompt){
        $_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
        registerError($prompt,'warning');
        header('Location: /login/');
        exit;
    }
    function redirect($location = "current"){
        if($location == "current") {
            $location = $_SERVER['REQUEST_URI'];
        }
        header("Location: ".$location);
        exit();
    }
    
    function forgotPassword($mail) {
        $key = generatePassword(20);
        if($GLOBALS['db']->setResetKey($mail,$key)){
            registerError("A link with further instructions has been sent to ".$mail,'success');
            $message = '<html>
                            <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                <title>[Hockey Gear] Password reset</title>
                            <head>
                            <body>
                                <p>Someone, hopefully you. Has issued a password reset for your account.</p>
                                <p>If you didn´t reset your password you can simply login with your old password and the following link will cease to exist.</p>
                                <p>You save your new password at '.$_SERVER['HTTP_HOST'].'/reset-password/'.$key.'</p>
                            </body>
                        </html>';
            $message = wordwrap($message, 70, "\r\n"); 
            $to      = $mail;
            $subject = '[Hockey Gear] Password reset';
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: Hockey Gear <noreply@hockeygear.com>' . "\r\n";
            $headers .= 'Reply-To: webmaster@hockeygear.com' . "\r\n";
            $headers .= 'X-Mailer: PHP/' . phpversion();
            mail($to, $subject, $message, $headers);
            redirect();
        } else {
            registerError("Couldn't reset password. Double check your e-mail","danger");
            redirect();
        }
    }
    
    function savePassword($key,$password){
        if($user = $GLOBALS['db']->getResetKey($key)){ // If reset key exists, get SSNr to save new password to.
            if ($GLOBALS['db']->dbEditUser($user['SSNr'],"ResetKey",null,"Password",$password)) {
                registerError("Your new password has been saved", "success");
                redirect("/login/");
            } else {
                registerError("Password couldn't be saved", "danger");
                redirect();
            }
        } else {
            registerError("Your reset key is not valid, please reset your password again", "danger");
            redirect("/reset-password/");
        }
    }
    
    function setCurrency($id) {
        $array = $GLOBALS['db']->dbGetCurrency($id);
        if (isset($_SESSION['currency'])){
            registerError("Currency changed to ".$array['CurrencyName'],"success");
        }
        $_SESSION['currency']['multiplier'] = $array['CurrencyMultiplier'];
        $_SESSION['currency']['name'] = $array['CurrencyName'];
        $_SESSION['currency']['sign'] = $array['CurrencySign'];
        $_SESSION['currency']['id'] = $array['CurrencyId'];
        $_SESSION['currency']['position'] = $array['CurrencyLayout'];
        
    }
    
    function showCurrency($value){
        if(isset($_SESSION['currency']['position']) && $_SESSION['currency']['position'] != "suffix"){
            return $_SESSION['currency']['sign'].number_format($value/$_SESSION['currency']['multiplier'], 2, '.', '');
        } else {
            return number_format($value/$_SESSION['currency']['multiplier'], 2, '.', '')." ".$_SESSION['currency']['sign'];
        }
    }
    
    function itemsInCart(){
        if(isset($_SESSION['cart']['items'])){
            $cartAmount = 0;
            $suffix = "item";
            foreach ($_SESSION['cart']['items'] as $key => $value){
                $cartAmount += $value['amount'];
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
    function listUsersOrders(){
        $orders=getUsersOrders($_SESSION['LoginSSNr']);
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
                      <td><a href="/settings/orders/'.$orders[$i]->OrderId.'/" class="btn btn-default">Details</a></td>
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
    function listUserSingleOrder(){
        $order=getOrder($_GET['order']);
        $user=getUser($order->SSNr);
        echo '<div class="panel panel-primary">
                    <!-- Default panel contents -->
                    <div class="panel-heading ">Order '.$order->OrderId.'</div>
                    <div class="panel-body">
                      <table class="table">
                        <th>Invoice '.$order->OrderId.'</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <tr>
                          <td class="bold">Customer</td>
                          <td></td>
                          <td class="bold">'.$user->FirstName.' '.$user->LastName.'</td>
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
                        $GLOBALS['totalAmount']=0;
                        $GLOBALS['shippingCost']=$order->ShippingCost;
                        for($i=0;$i<count($order->OrderList);$i++){
                            echo '<tr>
                              <td>'.$order->OrderList[$i]->Name.'</td>
                              <td>'.showCurrency($order->OrderList[$i]->ProductPrice).'</td>
                              <td>'.$order->OrderList[$i]->Amount.'</td>
                              <td>0</td>
                              <td>'.$order->OrderList[$i]->Amount.'</td>
                              <td class="bold">'.showCurrency($order->OrderList[$i]->Amount*$order->OrderList[$i]->ProductPrice).'</td>
                            </tr>';
                            $GLOBALS['totalAmount']+=$order->OrderList[$i]->Amount*$order->OrderList[$i]->ProductPrice;
                        }
                        echo '<tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td class="bold">Total (with VAT 25%)</td>
                          <td class="bold">'.showCurrency($GLOBALS['totalAmount']).' (<span title="without VAT">'.showCurrency($GLOBALS['totalAmount']*0.8).')</span> </td>
                        </tr>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td class="bold">Shipping cost</td>
                          <td class="bold">'.showCurrency($GLOBALS['shippingCost']).'</td>
                        </tr>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td class="bold">Total cost, including shipping etc..</td>
                          <td class="bold">'.showCurrency($GLOBALS['totalAmount']+$GLOBALS['shippingCost']).'</td>
                        </tr>
                      </table>

                      <table>
                        <tr>
                          <td><a href="/settings/orders/" class="btn btn-default">Back</a></td>
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
    function listProductsFromTaxanomy($TaxanomyId){
        if($TaxanomyId){
            $products=NULL;
            echo '<div class="row">';
            recursiveListProducts($TaxanomyId);
            echo '</div>';
        }

    }
    function recursiveListProducts($TaxanomyId){
        $products=getProductsFromTaxanomy($TaxanomyId);
        if($products){
            for($i=0;$i<count($products);$i++){
                echo '<div class="col-lg-4">
                          <img class="img-circle" src="'.$products[$i]->ImgUrl.'" alt="Generic placeholder image">
                          <h2>'.$products[$i]->Name.'</h2>
                          <h3>'.showCurrency($products[$i]->Price).'</h3>
                          <p>'.$products[$i]->Description.'</p>
                          <p>
                            <form method="post">             <a href="/products/'.$_GET['category'].'-';
                if(isset($_GET['category-name'])){
                    echo toAscii($_GET["category-name"]);
                }
                echo '/'.$products[$i]->ProductId.'-'.toAscii($products[$i]->Name).'"class="btn btn-default">View details</a>
                            <button class="btn btn-primary" name="add-to-cart" value="'.$products[$i]->ProductId.'" type="submit">Add to cart</button></form>
                          </p>
                    </div>';
                    $children=$GLOBALS['db']->dbGetTaxanomyChildren($TaxanomyId);
                    foreach($children as $child){
                        recursiveListProducts($child['TaxanomyId']);
                    }
            }
        }else{
            $children=$GLOBALS['db']->dbGetTaxanomyChildren($TaxanomyId);
            foreach($children as $child){
                recursiveListProducts($child['TaxanomyId']);
            }
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
          <h3>'.showCurrency($product->Price).'</h3>
          <p class="pID">ProductId: '.$product->ProductId.'</p>
          <p>'.$product->Description.'</p>
          <p class="pID">Weight: '.$product->ProductWeight.'gram</p>
          <p>
            <form method="post">             <a href="/products/'.$_GET['category'].'-'.toAscii($_GET['category-name']).'/"class="btn btn-default">Back</a>
            <button class="btn btn-primary" name="add-to-cart" value="'.$product->ProductId.'" type="submit">Add to cart</button> (currently in stock: '.$product->Stock.')</form>

          </p>
        </div>
      </div>';
        }
    }
    function listProfile(){
        $user=getUser($_SESSION['LoginSSNr']);
        echo '<p>'.$user->FirstName.' '.$user->LastName.'</p>
          <p>'.$user->StreetAddress.'</p>
          <p>'.$user->PostAddress.' '.$user->City.'</p>
          <p>'.$user->Mail.'</p>
          <p>'.$user->SSNr.'</p>';
    }
    function listEditProfile(){
        $user=getUser($_SESSION['LoginSSNr']);

        echo '<div class="well well-lg">
        <h2 class="form-signin-heading">Edit profile</h2>
        <form method="post" class="form-signin" role="form">
          <div class="row">
            <div class="col-lg-6">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                <input readonly name="user-ssn" type="text" value="'.$user->SSNr.'" class="form-control" placeholder="Social Security Number">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope" ></span></span>
                <input readonly name="user-mail" type="email" value="'.$user->Mail.'" class="form-control" placeholder="E-Mail">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input pattern="^[A-ZÅÄÖa-zåäö]+$" required name="user-first-name" type="text" class="form-control" value="'.$user->FirstName.'" placeholder="First Name">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input pattern="^[A-ZÅÄÖa-zåäö]+$" required name="user-last-name" type="text" class="form-control" value="'.$user->LastName.'" placeholder="Last Name">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-earphone" ></span></span>
                <input pattern="^(46|\+46|0)(-?\s?[0-9]+)+$" name="user-phone" type="tel" class="form-control" value="'.$user->Telephone.'" placeholder="Phone">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="user-street-address" type="text" class="form-control" value="'.$user->StreetAddress.'" placeholder="Street Address">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="user-post-address" type="text" class="form-control" value="'.$user->PostAddress.'" placeholder="Post Address">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->

            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="user-city" type="text" class="form-control" value="'.$user->City.'" placeholder="City">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
          </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock" ></span></span>
                <input pattern="^[a-zA-ZåäöÅÄÖ0-9]{6,30}$" name="user-old-password" type="password" class="form-control" placeholder="Old Password">
            </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock" ></span></span>
                <input pattern="^[a-zA-ZåäöÅÄÖ0-9]{6,30}$" data-message="Your password needs to be at least 6 characters long." name="user-new-password" type="password" class="form-control" placeholder="New Password">
            </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <button name="user-submit" class="btn btn-primary btn-block" value="edit" type="submit">Save changes</button>
            </div>
          </div>
        </form>
      </div>';
    }
    function listCart(){
        $totalCost=0;
        echo '<form method="post">
            <table class="table">
            <thead>
            <th>Name</th>
            <th>Amount</th>
            <th></th>
            <th>Value</th>
            <th>Total</th>
            
            </thead><tbody>';
        $totalWeight=0;
        foreach($_SESSION['cart']['items'] as $key => $value){
            $product=getProduct($key);
            $_SESSION['cart']['items'][$key]['id'] = $product->ProductId;
            $_SESSION['cart']['items'][$key]['name'] = $product->Name;
            $_SESSION['cart']['items'][$key]['price'] = $product->Price;
            $_SESSION['cart']['items'][$key]['weight'] = $product->ProductWeight;
            echo    '<tr>
                        <td>'.$product->Name.'</td>
                        <td>
                            <input type="text" class="form-control" name="'.$_SESSION['cart']['items'][$key]['id'].'" value="'.$value['amount'].'">
                        </td>
                        <td>
                            <button type="submit" class="btn btn-primary" name="cart-update"> <span class="glyphicon glyphicon-refresh"></span></button>
                            <button type="submit" class="btn btn-danger" name="cart-remove" value="'.$_SESSION['cart']['items'][$key]['id'].'"><span class="glyphicon glyphicon-remove"></button>
                        </td>
                        <td><strong>'.showCurrency($_SESSION['cart']['items'][$key]['price']).'</strong> ('.showCurrency($_SESSION['cart']['items'][$key]['price']*0.8).')</td>
                        <td><strong>'.showCurrency($_SESSION['cart']['items'][$key]['price']*$value['amount']).'</strong> ('.showCurrency($_SESSION['cart']['items'][$key]['price']*$value['amount']*0.8).')</td>
                    </tr>';
            $totalCost+=($_SESSION['cart']['items'][$key]['price']*$value['amount']);
            $totalWeight+=$product->ProductWeight*$value['amount'];
        }

        if($totalWeight<2000){

        }
        $shippingCost = calculateShippingCost();
        echo '  </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="bold">Total (with VAT 25%)</td>
                        <td><strong>'.showCurrency($totalCost).'</strong> ('.showCurrency($totalCost*0.8).')</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="bold">Shipping Cost</td>
                        <td><strong>'.showCurrency($shippingCost).'</strong> ('.(intval($totalWeight)/1000).' kg)</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="bold">Total including shipping</td>
                        <td><strong>'.showCurrency($totalCost+$shippingCost).'</strong> ('.showCurrency($totalCost*0.8+$shippingCost).')</td>
                    </tr>
                </tfoot>

          </table>
        </form>';
    }
    
    function listPersonalInfo(){
        $user=getUser($_SESSION['LoginSSNr']);
        if(!isset($_SESSION['form']['cart'])) {
            $_SESSION['form']['cart'] = array( // Save form data in session
                                    'first-name'                => $user->FirstName,
                                    'last-name'                 => $user->LastName,
                                    'shipping-street-address'   => $user->StreetAddress,
                                    'billing-street-address'    => $user->StreetAddress,
                                    'shipping-post-address'     => $user->PostAddress,
                                    'billing-post-address'      => $user->PostAddress,
                                    'shipping-city'             => $user->City,
                                    'billing-city'              => $user->City);
        }
        $_SESSION['form']['cart']['first-name'] = $user->FirstName;
        $_SESSION['form']['cart']['last-name'] = $user->LastName;
        $attribute = "required";
        echo '<form action="/cart/" method="post">
          <table class="table">
            <tr>
              <th>Full Name</th>
              <th>'.$_SESSION['form']['cart']['first-name'].' '.$_SESSION['form']['cart']['last-name'].'</th>
            </tr>
            <tr>
              <th>Shipping Address</th>
              <th>Billing Address</th>
            </tr>
            <tr>
              <td>
                <div class="input-group">
                  <span class="input-group-addon inputLeft">Street Address</span>
                  <input '.$attribute.' name="shipping-street-address" type="text" class="form-control" placeholder="Street Address" value="'.fillForm('cart','shipping-street-address').'">
                </div>
              </td>
              <td><div class="input-group">
                <span class="input-group-addon inputLeft">Street Address</span>
                <input '.$attribute.' name="billing-street-address" type="text" class="form-control" value="'.fillForm('cart','billing-street-address').'">
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="input-group">
                <span class="input-group-addon inputLeft">Post Address</span>
                <input '.$attribute.' name="shipping-post-address"type="text" class="form-control" value="'.fillForm('cart','shipping-post-address').'">
              </div>
            </td>
            <td>
              <div class="input-group">
                <span class="input-group-addon inputLeft">Post Address</span>
                <input '.$attribute.' name="billing-post-address" type="text" class="form-control" value="'.fillForm('cart','billing-post-address').'">
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="input-group">
                <span class="input-group-addon inputLeft">City</span>
                <input '.$attribute.' name="shipping-city" type="text" class="form-control" value="'.fillForm('cart','shipping-city').'">
              </div>
            </td>
            <td>
              <div class="input-group">
                <span class="input-group-addon inputLeft">City</span>
                <input '.$attribute.' name="billing-city" type="text" class="form-control" value="'.fillForm('cart','billing-city').'">
              </div>
            </td>
          </tr>
          <tr>
            <th>Credit Card</th>
            <th></th>
          </tr>
          <tr>
            <td>
              <div class="input-group">
                <span class="input-group-addon inputLeft">Full Name</span>
                <input '.$attribute.' name="card-full-name" placeholder="Full Name as it appears on the card" required type="text" class="form-control" value="'.fillForm('cart','card-full-name').'">
              </div>
            </td>
            <td></td>
          <tr>
              <td>
              <div class="input-group">
                <span class="input-group-addon inputLeft">Month</span>
                  <input '.$attribute.' name="card-expiry-month" placeholder="09" required type="text" class="form-control" value="'.fillForm('cart','card-expiry-month').'">
              </div>
              </td>
              <td>
              <div class="input-group">
                <span class="input-group-addon inputLeft">Year</span>
                  <input '.$attribute.' name="card-expiry-year" placeholder="15" required type="text" class="form-control" value="'.fillForm('cart','card-expiry-year').'">
              </div>
            </td>
          </tr>
          </tr>
          <tr>
            <td>
              <div class="input-group">
                <span class="input-group-addon inputLeft">Card Number</span>
                <input '.$attribute.' placeholder="4012 8888 8888 1881" pattern="^((4\d{3})|(5[1-5]\d{2})|(6011))-?\s?\d{4}-?\s?\d{4}-?\s?\d{4}|3[4,7]\d{13}$" name="card-number" type="text" class="form-control" value="'.fillForm('cart','card-number').'">
              </div>
            </td>
            <td>
              <div class="input-group">
                <span class="input-group-addon inputLeft">CVC</span>
                <input '.$attribute.' placeholder="The security code is located on the back of your card" name="card-cvc" pattern="^\d{3}$" type="password" class="form-control" value="">
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <a class="btn btn-default" href="/cart/">&laquo; Back</a>
              <button '.$attribute.' type="submit" class="btn btn-info" name="review-order">Review before placing order</button>
            </td>
            <td></td>
          </tr>
        </table>
      </form>';
    }
    
    function shoppingCart(){
        $array = array();
        foreach($_SESSION['cart']['items'] as $key => $value){
            $array[$_SESSION['cart']['items'][$key]['id']] = $_SESSION['cart']['items'][$key]['amount'];
        }
        return $array;
    }
    
    function listReview(){
        $totalCost=0;
        echo '<table class="table">
            <thead>
            <th>Name</th>
            <th>Amount</th>
            <th>Value</th>
            <th>Total</th>
            
            </thead><tbody>';
        foreach($_SESSION['cart']['items'] as $key => $value){
            
            echo '<tr>
                    <td>'.$value['name'].'</td>
                    <td>
                        '.$value['amount'].'
                    </td>
                    <td>'.showCurrency($value['price']).'</td>
                    <td>'.showCurrency($value['price']*$value['amount']).'</td>
                </tr>';
            $totalCost+=($value['price']*$value['amount']);
        }
        $shippingCost = $_SESSION['form']['cart']['shipping-cost'];
        echo '  </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="bold">Total (with VAT 25%)</td>
                        <td><strong>'.showCurrency($totalCost).'</strong> ('.showCurrency($totalCost*0.8).')</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="bold">Shipping Cost</td>
                        <td><strong>'.showCurrency($shippingCost).'</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="bold">Total including shipping</td>
                        <td><strong>'.showCurrency($totalCost+$shippingCost).'</strong> ('.showCurrency($totalCost*0.8+$shippingCost).')</td>
                    </tr>
                </tfoot>
        
          </table>
          <table class="table">
            <tr>
              <th>Full Name</th>
              <th>'.$_SESSION['form']['cart']['first-name'].' '.$_SESSION['form']['cart']['last-name'].'</th>
            </tr>
            <tr>
              <th>Shipping Address</th>
              <th>Billing Address</th>
            </tr>
            <tr>
              <td>
                  '.$_SESSION['form']['cart']['shipping-street-address'].'
              </td>
              <td>
                '.$_SESSION['form']['cart']['billing-street-address'].'
            </td>
          </tr>
          <tr>
            <td>
                '.$_SESSION['form']['cart']['shipping-post-address'].'
            </td>
            <td>
              '.$_SESSION['form']['cart']['billing-post-address'].'
            </td>
          </tr>
          <tr>
            <td>
              '.$_SESSION['form']['cart']['shipping-city'].'
            </td>
            <td>
              '.$_SESSION['form']['cart']['billing-city'].'
            </td>
          </tr></table>
          <table class="table">
          <thead>
          <tr>
            <th>Credit Card</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>
              '.$_SESSION['form']['cart']['card-full-name'].'
            </td>
            <td>
              '.$_SESSION['form']['cart']['card-expiry-month'].'/'.$_SESSION['form']['cart']['card-expiry-year'].'
            </td>
          </tr>
          <tr>
            <td>
              '.$_SESSION['form']['cart']['card-number'].'
            </td>
            <td>
              ***
            </td>
          </tr>
          <tr>
            <td><form action="/cart/review/" method="post">
              <a class="btn btn-default" href="/cart/">&laquo; Back</a>
              
              <button type="submit" class="btn btn-info" name="place-order">Place order</button>
              </form>
            </td>
            <td></td>
          </tr>
          </tbody>
        </table>';
    }
    function listAdminSingleOrder($OrderId){
        $order=getOrder($OrderId);
        $user=getUser($order->SSNr);
        if($order){
            echo '<div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading ">Order</div>
        <div class="panel-body">
          <table class="sortable table">
            <tr>
              <td class="bold">Customer</td>
              <td></td>
              <td class="bold">'.$user->FirstName.' '.$user->LastName.' ('.$order->SSNr.')</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="bold">Order Id</td>
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
              <td class="bold">IP-Address</td>
              <td></td>
              <td>'.$order->OrderIP.'</td>
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
            for($i=0;$i<count($order->OrderList);$i++){
                echo '<tr>
                  <td>'.$order->OrderList[$i]->Name.'</td>
                  <td>'.showCurrency($order->OrderList[$i]->ProductPrice).'</td>
                  <td>'.$order->OrderList[$i]->Amount.'</td>
                  <td>0</td>
                  <td>'.$order->OrderList[$i]->Amount.'</td>
                  <td class="bold">'.showCurrency(($order->OrderList[$i]->Amount)*($order->OrderList[$i]->ProductPrice)).'</td>
                </tr>';
                $totalAmount+=($order->OrderList[$i]->Amount)*($order->OrderList[$i]->ProductPrice);
            }

            $shippingCost=$order->ShippingCost;
            echo '<tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="bold">Total (with VAT 25%)</td>
              <td class="bold">'.showCurrency($totalAmount).' (<span title="without VAT">'.showCurrency($totalAmount*0.8).')</span> </td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="bold">Shipping cost</td>
              <td class="bold">'.showCurrency($shippingCost).'</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="bold">Total cost, including shipping etc..</td>
              <td class="bold">'.showCurrency($shippingCost+$totalAmount).' (<span title="without VAT">'.showCurrency($totalAmount*0.8+$shippingCost).')</td>
            </tr>
          </table>
          <table>
            <tr>
              <td><a href="/admin/orders/" class="btn btn-default">Back</a></td>
              <td><form method="post"><button name="order-delete" value="'.$order->OrderId.'" class="btn btn-danger" type="submit">Delete</button></form></td>
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
                  <td class="order-value">'.showCurrency($orders[$i]->OrderPrice+$orders[$i]->ShippingCost).'</td>
                  <td><a href="/admin/orders/'.$orders[$i]->OrderId.'/" class="btn btn-default">View Order</a></td>
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
                <select class="form-control" name="product-category">';
                $taxanomies=getAllTaxanomies();
                for($i=0;$i<count($taxanomies);$i++){
                    if($taxanomies[$i]->Id == 1){ // Check if we are on parent category
                        echo '<option selected value="'.$taxanomies[$i]->Id.'">No category</option>';
                    } else {
                        echo '<option value="'.$taxanomies[$i]->Id.'">'.$taxanomies[$i]->Name.' ('.$taxanomies[$i]->Id.')</option>';
                    }
                }
                echo '</select>
              </div>
            </div>
              <div class="col-lg-4">
                <span class="btn btn-block btn-default btn-file">Browse image<input name="product-image" required data-message="You need to upload an image" accept="image/jpeg" type="file">
                </span>
              </div>
          </div>
        <div class="row">
              <div class="col-lg-2">
                  <a href="/admin/products/" class="btn btn-default btn-block">Back</a>
              </div>
              <div class="col-lg-6">
              </div>
              <div class="col-lg-4">
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
        <div class="panel-heading ">Edit Product</div>
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
                <select class="form-control" name="product-category" value="'.$product->Taxanomy.'">';
                $taxanomies=getAllTaxanomies();
                for($i=0;$i<count($taxanomies);$i++){
                    if($taxanomies[$i]->Id == 1){ // Check if we are on parent category
                        if($taxanomies[$i]->Id == $product->Taxanomy){
                            echo '<option selected value="'.$taxanomies[$i]->Id.'">No category</option>';
                        } else {
                            echo '<option value="'.$taxanomies[$i]->Id.'">No category</option>';
                        }
                    } else {
                        if($taxanomies[$i]->Id == $product->Taxanomy){
                            echo '<option selected value="'.$taxanomies[$i]->Id.'">'.$taxanomies[$i]->Name.' ('.$taxanomies[$i]->Id.')</option>';
                        } else {
                            echo '<option value="'.$taxanomies[$i]->Id.'">'.$taxanomies[$i]->Name.' ('.$taxanomies[$i]->Id.')</option>';
                        }
                    }                    
                }
                echo '</select>
              </div>
            </div>
              <div class="col-lg-4">
                <span class="btn btn-block btn-default btn-file">Browse image<input name="product-image" data-message="You need to upload an image" accept="image/jpeg" type="file">
                </span>
              </div>
          </div>
        <div class="row">
              <div class="col-lg-2">
                  <a href="/admin/products/" class="btn btn-default btn-block">Back</a>
              </div>
              <div class="col-lg-2">
              </div>
              <div class="col-lg-4">
                  <button name="product-delete" class="btn btn-danger btn-block" type="submit">Delete product</button>
              </div>
              
              <div class="col-lg-4">
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
                $taxanomy=getTaxanomy($products[$i]->Taxanomy);
                echo '<tr>
              <td class="product-name">'.$products[$i]->Name.'</td>
              <td class="product-id">'.$products[$i]->ProductId.'</td>
              <td class="product-value">'.showCurrency($products[$i]->Price).'</td>
              <td class="product-category">'.$taxanomy->Name.' ('.$products[$i]->Taxanomy.')</td>
              <td><a href="/admin/products/'.$products[$i]->ProductId.'/" class="btn btn-default">Edit Product</a></td>
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
        if($user->IsAdmin) {
            $admin = "selected";
            $noAdmin = ""; 
        } else {
            $admin = "";
            $noAdmin = "selected";
        }
        if($user){
            echo '<div class="panel panel-primary">
      <div class="panel-heading">Edit User</div>
      <div class="panel-body">
        <form method="post" class="form-signin" role="form">
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                <input readonly name="user-ssn" type="text" value="'.$user->SSNr.'" class="form-control" placeholder="Social Security Number">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope" ></span></span>
                <input readonly name="user-mail" type="email" value="'.$user->Mail.'" class="form-control" placeholder="E-Mail">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock" ></span></span>
                <input readonly name="user-password" type="password" value="justanotherwebshop" class="form-control" placeholder="Password">
                <span class="input-group-btn">
                    <button class="btn btn-default" name="reset-password" type="submit">Reset</button>
                </span>
            </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input pattern="^.+$" required name="user-first-name" type="text" class="form-control" value="'.$user->FirstName.'" placeholder="First Name">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input pattern="^.+$" required name="user-last-name" type="text" class="form-control" value="'.$user->LastName.'" placeholder="Last Name">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-earphone" ></span></span>
                <input pattern="^(46|\+46|0)(-?\s?[0-9]+)+$" name="user-phone" type="tel" class="form-control" value="'.$user->Telephone.'" placeholder="Phone">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="user-street-address" type="text" class="form-control" value="'.$user->StreetAddress.'" placeholder="Street Address">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="user-post-address" type="text" class="form-control" value="'.$user->PostAddress.'" placeholder="Post Address">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->

            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="user-city" type="text" class="form-control" value="'.$user->City.'" placeholder="City">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
          </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-2">
                 <a href="/admin/users/" class="btn btn-default btn-block">Back</a>
            </div>
            <div class="col-lg-2">
            </div>
            <div class="col-lg-4">
              <div class="input-group">
                  <span required class="input-group-addon">Access level</span>
                  <select class="form-control" name="user-admin">
                      <option '.$noAdmin.' value=false>User</option>
                      <option '.$admin.' value=true>Administrator</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
              <button name="user-delete" class="btn btn-danger btn-block" value="'.$user->SSNr.'" type="submit">Delete User</button>
            </div>
            <div class="col-lg-2">
              <button name="user-submit" class="btn btn-primary btn-block" value="edit" type="submit">Save changes</button>
            </div>
          </div>
        </form>
      </div>
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
                      <th><input data-sort="user-ssnr" type="button" class="sort btn btn-default" value="Social Security Number"></th>
                      <th><input data-sort="user-name" type="button" class="sort btn btn-default" value="Full Name"></th>
                      <th><input placeholder="Search.." class="form-control search" /></th></thead><tbody class="list">';
        if($users){

            for($i=0;$i<count($users);$i++){
                echo '<tr>
                          <td class="user-ssnr">'.$users[$i]->SSNr.'</td>
                          <td class="user-name">'.$users[$i]->FirstName.' '.$users[$i]->LastName.'</td>
                          <td><a href="/admin/users/'.$users[$i]->SSNr.'/" class="btn btn-default">Edit User</a></td>
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
        $taxanomies=$GLOBALS['db']->dbGetTaxanomyTree();
        if($taxanomies){
            echo '<div class="panel panel-primary">
                      <div class="panel-heading">Categories</div>
                      <div class="panel-body">
                        <ul class="list-unstyled">';
                            foreach($taxanomies as $taxanomy){
                                echo '<li>'.$taxanomy['TaxanomyName'].' <a href="/admin/categories/'.$taxanomy['TaxanomyId'].'" class="btn btn-default btn-xs">Edit</a>
                                </li>';
                                recursiveAdminTaxanomy($taxanomy['TaxanomyChildren']);
                            }
                        echo '<li><a href="/admin/categories/new" class="btn btn-primary">Add category</a>
                        </ul>
                      </div>
                    </div>';
        }
    }
    function recursiveAdminTaxanomy($taxanomy){
        if($taxanomy){
            echo '<ul class="list-styled">';
            foreach($taxanomy as $child){
                echo '<li>'.$child['TaxanomyName'].' <a href="/admin/categories/'.$child['TaxanomyId'].'" class="btn btn-default btn-xs">Edit</a>
                                </li>';
                recursiveAdminTaxanomy($child['TaxanomyChildren']);
            }
            echo '</ul>';
        }
    }

    function listAdminSingleTaxanomy(){
        if($_GET['category'] != "new"){
        $taxanomy=getTaxanomy($_GET['category']);
        echo '<div class="panel panel-primary">
                  <div class="panel-heading">Edit Category</div>
                  <div class="panel-body">
                    <form method="post" class="form-signin" role="form">
                          <div class="row">
                            <div class="col-lg-4">
                              <div class="input-group">
                                <span class="input-group-addon">Id</span>
                                <input readonly name="taxanomy-id" value="'.$taxanomy->Id.'" type="text" class="form-control" placeholder="Automatically generated">
                              </div><!-- /input-group -->
                            </div><!-- /.col-lg-6 -->
                            <div class="col-lg-4">
                              <div class="input-group">
                                <span class="input-group-addon">Name</span>
                                <input pattern="^\w+$" required name="taxanomy-name" value="'.$taxanomy->Name.'" type="text" class="form-control" placeholder="Category Name">
                              </div><!-- /input-group -->
                            </div><!-- /.col-lg-6 -->
                            <div class="col-lg-4">
                               <div class="input-group">
                                <span class="input-group-addon">Parent</span>
                                <select class="form-control" name="taxanomy-parent">';
                                $taxanomies=getAllTaxanomies();
                                for($i=0;$i<count($taxanomies);$i++){
                                    if($taxanomies[$i]->Id == 1){
                                        if($taxanomies[$i]->Id==$taxanomy->Parent){
                                            echo '<option selected value="'.$taxanomies[$i]->Id.'">No parent</option>';
                                        }else{
                                            echo '<option value="'.$taxanomies[$i]->Id.'">No parent</option>';
                                        }
                                    } else {
                                        if($taxanomies[$i]->Id==$taxanomy->Parent){
                                            echo '<option selected value="'.$taxanomies[$i]->Id.'">'.$taxanomies[$i]->Name.' ('.$taxanomies[$i]->Id.')</option>';
                                        }else if($taxanomies[$i]->Id==$taxanomy->Id) {

                                        }else {
                                            echo '<option value="'.$taxanomies[$i]->Id.'">'.$taxanomies[$i]->Name.' ('.$taxanomies[$i]->Id.')</option>';
                                        }
                                    }
                                    
                                }
                                echo '</select>
                              </div>
                            </div>
                            </div><!-- /.row -->
                            <div class="row">
                                <div class="col-lg-2">
                                      <a href="/admin/categories/" class="btn btn-default btn-block">Back</a>
                                </div>
                                <div class="col-lg-6">
                                </div>
                                <div class="col-lg-2">
                                  <button name="taxanomy-delete" class="btn btn-danger btn-block" type="submit" value="delete">Delete</button>
                                </div>
                                <div class="col-lg-2">
                                      <button name="taxanomy-edit" class="btn btn-primary btn-block" type="submit" value="new">Edit Category</button>
                                </div>
                            </div>
                        </form>
                  </div>
                </div>';
        } else {
            echo '<div class="panel panel-primary">
                      <div class="panel-heading">Add Category</div>
                      <div class="panel-body">
                        <form method="post" class="form-signin" role="form">
                              <div class="row">
                                <div class="col-lg-4">
                                  <div class="input-group">
                                    <span class="input-group-addon">Id</span>
                                    <input readonly name="taxanomy-id" type="text" class="form-control" placeholder="Automatically generated">
                                  </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                                <div class="col-lg-4">
                                  <div class="input-group">
                                    <span class="input-group-addon">Name</span>
                                    <input pattern="^\w+$" required name="taxanomy-name" type="text" class="form-control" placeholder="Category Name">
                                  </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                                <div class="col-lg-4">
                                   <div class="input-group">
                                    <span class="input-group-addon">Parent</span>
                                    <select class="form-control" name="taxanomy-parent">';
                                $taxanomies=getAllTaxanomies();
                                for($i=0;$i<count($taxanomies);$i++){
                                    if($taxanomies[$i]->Id == 1){
                                        echo '<option value="'.$taxanomies[$i]->Id.'">No parent</option>';
                                    }else{
                                        echo '<option value="'.$taxanomies[$i]->Id.'">'.$taxanomies[$i]->Name.' ('.$taxanomies[$i]->Id.')</option>';
                                    }
                                }
                                echo '</select>
                                </div>
                                </div>
                                </div><!-- /.row -->
                                <div class="row">
                                <div class="col-lg-2">
                                      <a href="/admin/categories/" class="btn btn-default btn-block">Back</a>
                                </div>
                                <div class="col-lg-6">
                                </div>
                                <div class="col-lg-4">
                                      <button name="taxanomy-add" class="btn btn-primary btn-block" type="submit" value="new">Add Category</button>
                                </div>
                            </div>
                            </form>
                      </div>
                    </div>';
        }
    }
    function listTaxanomies(){
        $taxanomies=getAllTaxanomies();
        echo '<div class="container dropdownCat">
                 <li class="dropdown dropdownCategory">
                  <a id="drop4" role="button" data-toggle="dropdown" href="#">Choose Category <b class="caret"></b></a>
                  <ul id="menu1" class="dropdown-menu dropdown-menuCategory" role="menu" aria-labelledby="drop4">';
            for($i=0;$i<count($taxanomies);$i++){
                if($taxanomies[$i]->Id != 1) {
                    echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="/products/'.$taxanomies[$i]->Id.'-'.toAscii($taxanomies[$i]->Name).'">'.$taxanomies[$i]->Name.'</a></li>';
                }
                
            }
         echo      '</ul>
                </li>
              </div>';
    }
    function listCurrencies(){
        $currencies=getAllCurrencies();
        echo '<li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="mobile">Currencies  </span><i class="fa fa-money currencies"></i></a>
                      <ul class="dropdown-menu">';

            for($i=0;$i<count($currencies);$i++){
                //echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="/products/'.$currencies[$i]->Id.'-'.$currencies[$i]->Name.'">'.$currencies[$i]->Name.'</a></li>';
                echo '<li><a href="?setcurrency='.($currencies[$i]->Id).'">'.$currencies[$i]->Name.'</a></li>';
            }

        echo    '</ul>
              </li>';
    }
    function listAdminCurrencies(){
        $currencies=getAllCurrencies();
        echo '<div class="panel panel-primary">
                  <div class="panel-heading">Currencies</div>
                  <div class="panel-body">
                    <table id="sortable" class="table">
                        <thead>
                            <th><button data-sort="currency-name" class="sort btn btn-default">Currency</button></th>
                            <th><button data-sort="currency-value" class="sort btn btn-default">Value (in relation to Euro)</button></th>
                            <th><input placeholder="Search.." class="form-control search"></th>
                        </thead>
                        <tbody class="list">';
                for($i=0;$i<count($currencies);$i++){
                     echo       '<tr>
                                <th class="currency-name">'.$currencies[$i]->Name.' '.$currencies[$i]->Sign.'</th>
                                <th class="currency-value">'.$currencies[$i]->Multiplier.'</th>
                                <th><a class="btn btn-default" href="/admin/currencies/'.$currencies[$i]->Id.'">Edit Currency</a></th>
                            </tr>';
                    }
                 echo       '</tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th><a href="/admin/currencies/new/" class="btn btn-primary">Add Currency</a></th>
                            </tr>
                        </tfoot>
                    </table>
                  </div>
                </div>';
    }
    function listAdminSingleCurrency(){
        if($_GET['currency'] != "new"){
            $currency=getCurrency($_GET['currency']);
            if($currency->Layout == "suffix"){
                $suffix = "selected";
                $prefix = "";
            } else {
                $prefix = "selected";
                $suffix = "";
            }
            echo '<div class="panel panel-primary">
                      <div class="panel-heading">Edit Currency</div>
                      <div class="panel-body">
                        <form method="post" class="form-signin" role="form">
                              <div class="row">
                                <div class="col-lg-2">
                                  <div class="input-group">
                                    <span class="input-group-addon">ID</span>
                                    <input pattern="^(\w|\s)+$" readonly name="currency-id" type="text" class="form-control" value="'.$currency->Id.'">
                                  </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                                <div class="col-lg-4">
                                  <div class="input-group">
                                    <span class="input-group-addon">Name</span>
                                    <input pattern="^(\w|\s)+$" required name="currency-name" type="text" class="form-control" placeholder="Euro" value="'.$currency->Name.'">
                                  </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                                <div class="col-lg-2">
                                  <div class="input-group">
                                    <span class="input-group-addon">Sign</span>
                                    <input pattern="^.{0,4}$" required name="currency-sign" type="text" class="form-control" placeholder="€" value="'.$currency->Sign.'">
                                  </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                                <div class="col-lg-2">
                                  <div class="input-group">
                                    <span class="input-group-addon">Value</span>
                                    <input pattern="^(\d|[\.])+$" required name="currency-value" type="text" class="form-control" placeholder="1.0" value="'.$currency->Multiplier.'">
                                  </div><!-- /input-group -->
                                </div>
                                <div class="col-lg-2">
                                   <div class="input-group">
                                    <span class="input-group-addon">Position</span>
                                    <select class="form-control" name="currency-position">
                                      <option '.$prefix.' value="prefix">Prefix</option>
                                      <option '.$suffix.' value="suffix">Suffix</option>
                                    </select>
                                  </div>
                                </div>
                                
                                </div><!-- /.row -->
                                <div class="row">
                                    <div class="col-lg-2">
                                          <a href="/admin/currencies/" class="btn btn-default btn-block">Back</a>
                                    </div>
                                    <div class="col-lg-4">
                                    </div>
                                    <div class="col-lg-2">
                                          <button name="currency-delete" class="btn btn-danger btn-block" type="submit" value="new">Delete</button>
                                    </div>
                                    <div class="col-lg-4">
                                      <button name="currency-edit" class="btn btn-primary btn-block" type="submit" value="edit">Edit Currency</button>
                                    </div>
                                </div>
                                
                            </form>
                      </div>
                    </div>';
        } else {
            echo '<div class="panel panel-primary">
                      <div class="panel-heading">Add Currency</div>
                      <div class="panel-body">
                        <form method="post" class="form-signin" role="form">
                              <div class="row">
                                <div class="col-lg-2">
                                  <div class="input-group">
                                    <span class="input-group-addon">ID</span>
                                    <input pattern="^(\w|\s)+$" readonly name="currency-id" type="text" class="form-control">
                                  </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                                <div class="col-lg-4">
                                  <div class="input-group">
                                    <span class="input-group-addon">Name</span>
                                    <input pattern="^(\w|\s)+$" required name="currency-name" type="text" class="form-control" placeholder="Euro">
                                  </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                                <div class="col-lg-2">
                                  <div class="input-group">
                                    <span class="input-group-addon">Sign</span>
                                    <input pattern="^.{0,4}$" required name="currency-sign" type="text" class="form-control" placeholder="€">
                                  </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                                <div class="col-lg-2">
                                  <div class="input-group">
                                    <span class="input-group-addon">Value</span>
                                    <input pattern="^(\d|[\.])+$" required name="currency-value" type="text" class="form-control" placeholder="1.0">
                                  </div><!-- /input-group -->
                                </div>
                                <div class="col-lg-2">
                                   <div class="input-group">
                                    <span class="input-group-addon">Position</span>
                                    <select class="form-control" name="currency-position">
                                      <option selected value="prefix">Prefix</option>
                                      <option value="suffix">Suffix</option>
                                    </select>
                                  </div>
                                </div>
                                
                                </div><!-- /.row -->
                                <div class="row">
                                    <div class="col-lg-2">
                                          <a href="/admin/currencies/" class="btn btn-default btn-block">Back</a>
                                    </div>
                                    <div class="col-lg-6">
                                    </div>
                                    <div class="col-lg-4">
                                      <button name="currency-add" class="btn btn-primary btn-block" type="submit" value="new">Add Currency</button>
                                    </div>
                                </div>
                                
                            </form>
                      </div>
                    </div>';
        }   
    }
    
    function listAdminSinglePackage(){
        if($_GET['package'] != "new"){
            $package=$GLOBALS['db']->dbGetShipping($_GET['package']);
            echo '<div class="panel panel-primary">
                      <div class="panel-heading">Edit Package Weight</div>
                      <div class="panel-body">
                        <form method="post" class="form-signin" role="form">
                              <div class="row">
                                <div class="col-lg-6">
                                  <div class="input-group">
                                    <span class="input-group-addon">Max Weight (in gram)</span>
                                    <input pattern="^\d+$" value="'.$package['MaxWeight'].'" readonly name="shipping-max-weight" type="text" class="form-control" placeholder="2">
                                  </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                                <div class="col-lg-6">
                                  <div class="input-group">
                                    <span class="input-group-addon">Shipping Cost (in Euro)</span>
                                    <input pattern="^\d+$" value="'.$package['Price'].'" required name="shipping-cost" type="text" class="form-control" placeholder="5">
                                  </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                          <a href="/admin/shipping/" class="btn btn-default btn-block">Back</a>
                                    </div>
                                    <div class="col-lg-4">
                                    </div>
                                    <div class="col-lg-2">
                                          <button name="shipping-delete" class="btn btn-danger btn-block" type="submit" value="new">Delete</button>
                                    </div>
                                    <div class="col-lg-4">
                                      <button name="shipping-edit" class="btn btn-primary btn-block" type="submit" value="edit">Edit Package Weight</button>
                                    </div>
                                </div>
                            </form>
                      </div>
                    </div>';
        } else {
        echo '<div class="panel panel-primary">
                      <div class="panel-heading">Add Package Weight</div>
                      <div class="panel-body">
                        <form method="post" class="form-signin" role="form">
                              <div class="row">
                                <div class="col-lg-6">
                                  <div class="input-group">
                                    <span class="input-group-addon">Max Weight (in gram)</span>
                                    <input pattern="^\d+$" required name="shipping-max-weight" type="text" class="form-control" placeholder="2">
                                  </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                                <div class="col-lg-6">
                                  <div class="input-group">
                                    <span class="input-group-addon">Shipping Cost (in Euro)</span>
                                    <input pattern="^.+$" required name="shipping-cost" type="text" class="form-control" placeholder="5">
                                  </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                          <a href="/admin/shipping/" class="btn btn-default btn-block">Back</a>
                                    </div>
                                    <div class="col-lg-6">
                                    </div>
                                    <div class="col-lg-4">
                                      <button name="shipping-add" class="btn btn-primary btn-block" type="submit" value="new">Add Package Weight</button>
                                    </div>
                                </div>
                            </form>
                      </div>
                    </div>';
        
        }
    }
    
    function listShipping(){
        $shipping;
        foreach ($GLOBALS['db']->dbGetShippingAll() as $key => $value){
            $shipping[$value['MaxWeight']] = $value['Price'];
        }
        ksort($shipping);
        echo '<div class="panel panel-primary">
                  <div class="panel-heading">Shipping Packages</div>
                  <div class="panel-body">
                    <table id="sortable" class="table">
                        <thead>
                            <th><button data-sort="shipping-max-weight" class="sort btn btn-default">Max weight</button></th>
                            <th><button data-sort="shipping-cost" class="sort btn btn-default">Cost</button></th>
                            <th></th>
                        </thead>
                        <tbody class="list">';
        foreach($shipping as $key => $value){
            echo    '<tr>
                        <th class="shipping-max-weight">'.$key.'g</th>
                        <th class="shipping-cost">'.showCurrency($value).'</th>
                        <th><a class="btn btn-default" href="/admin/shipping/'.$key.'">View Package Weight</a></th>
                    </tr>';
            } 
        echo '</tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th><a href="/admin/shipping/new/" class="btn btn-primary">Add Shipping Weight</a></th>
                    </tr> 
                </tfoot>
            </table>
          </div>
        </div>
        <script>
            var options = {
                valueNames: [ "shipping-max-weight", "shipping-cost" ]
            };
            var sortable = new List("sortable", options);
        </script>';
    }
    
    function registerUser(){
        if($GLOBALS['db']->dbAddUser($_POST['user-ssn'],$_POST['user-mail'],$_POST['user-password'],$_POST['user-first-name'],$_POST['user-last-name'],$_POST['user-street-address'],$_POST['user-post-address'],$_POST['user-city'],$_POST['user-phone'])==TRUE){
            return true;
        }else{
            return false;
        }
    }
    function login(){
        if($CurrentUser=$GLOBALS['db']->dbMatchPassword($_POST['login-mail'],$_POST['login-password'])){
            $chars=array('1','2','3','4','5','6','7','8','9','0','a','b','c','d','e','f');

            $sessionkey="";
            for($i=0;$i<21;$i++){
                $sessionkey.=$chars[rand(0,count($chars)-1)];
            }
            if($GLOBALS['db']->dbEditUser($CurrentUser[0],"SessionKey",$sessionkey,"ResetKey",null)){
                $_SESSION['SessionKey']=$sessionkey;
                $_SESSION['LoginSSNr']=$CurrentUser[0];
                return true;
            }
        }else{
            return false;
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
            $order=new Order($data['OrderId'],$data['SSNr'],$data['OrderDate'],$data['Discount'],$data['ChargedCard'],$data['OrderIP'],$data['OrderList'],$data['OrderTotal'],$data['ShippingCost']);
        }
        return $order;
    }
    function getAllOrders() { // Returns an order from the order as an Order class.
        $data=$GLOBALS['db']->dbGetOrdersAll();
        $orders=NULL;
        for($i=0;$i<count($data);$i++){
            $orders[$i]=new Order($data[$i]['OrderId'],$data[$i]['SSNr'],$data[$i]['OrderDate'],$data[$i]['Discount'],$data[$i]['ChargedCard'],$data[$i]['OrderIP'],NULL,$data[$i]['OrderTotal'],$data[$i]['ShippingCost']);
        }
        return $orders;
    }
    function getUsersOrders($SSNr) { // Returns an order from the order as an Order class.
        $data=$GLOBALS['db']->dbGetUsersOrders($SSNr);
        $orders=NULL;
        for($i=0;$i<count($data);$i++){
            $orders[$i]=new Order($data[$i]['OrderId'],$data[$i]['SSNr'],$data[$i]['OrderDate'],$data[$i]['Discount'],$data[$i]['ChargedCard'],$data[$i]['OrderIP'],NULL,$data[$i]['OrderTotal'],$data[$i]['ShippingCost']);
        }
        return $orders;
    }
    // END ORDER ----------------------------------|


    // -------------------------------------
    //  TAXANOMY
    // -------------------------------------
    function getTaxanomy($TaxanomyId) { // Returns an order from the order as an Order class.
        $data=$GLOBALS['db']->dbGetTaxanomy($TaxanomyId);

        $taxanomy=NULL;
        if($data!=NULL){
            $taxanomy=new Taxanomy($data['TaxanomyId'],$data['TaxanomyName'],$data['TaxanomyParent']);
        }
        return $taxanomy;
    }
    function getAllTaxanomies() { // Returns an order from the order as an Order class.
        $data=$GLOBALS['db']->dbGetTaxanomiesAll();
        $taxanomies=NULL;
        for($i=0;$i<count($data);$i++){
            $taxanomies[$i]=new Taxanomy($data[$i]['TaxanomyId'],$data[$i]['TaxanomyName'],$data[$i]['TaxanomyParent']);
        }
        return $taxanomies;
    }
    // END TAXANOMY ----------------------------------|


    // -------------------------------------
    //  CURRENCY
    // -------------------------------------
    function getCurrency($CurrencyId) { // Returns an order from the order as an Order class.
        $data=$GLOBALS['db']->dbGetCurrency($CurrencyId);

        $currency=NULL;
        if($data!=NULL){
            $currency=new Currency($data['CurrencyId'],$data['CurrencyName'],$data['CurrencyMultiplier'],$data['CurrencySign'],$data['CurrencyLayout']);
        }
        return $currency;
    }
    function getAllCurrencies() { // Returns an order from the order as an Order class.
        $data=$GLOBALS['db']->dbGetCurrenciesAll();
        $currencies=NULL;
        for($i=0;$i<count($data);$i++){
            $currencies[$i]=new Currency($data[$i]['CurrencyId'],$data[$i]['CurrencyName'],$data[$i]['CurrencyMultiplier'],$data[$i]['CurrencySign'],$data[$i]['CurrencyLayout']);
        }
        return $currencies;
    }
    // END CURRENCY ----------------------------------|
?>