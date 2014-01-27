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
    
    function registerError($message, $type) {
        $_SESSION['error'] = array("message" => $message,"type" => $type);
    }
    
    function isAdmin() {
        if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) {
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

    function listProducts($listType){ // List products in the fashion specified.
        // Get a list of products from database and save the array in $products
        //Loop through array and add all products to $products as a Product Class
        $numargs=func_num_args();
        $arg_list=func_get_args();
        $pass_arg_list=NULL;
        for($i=1,$j=0;$i<$numargs;$i++,$j++){
            $pass_arg_list[$j]=$arg_list[$i];
        }
        $products=call_user_func_array("getProducts",$pass_arg_list);

        if ($listType == 'list') {
            echo '<ul class="product-list">';
            for ($i = 0; $i<count($products); $i++){
                echo '  <li>'.'<span class="name">'.$products[$i]->Name.'</span>'.'<span class="price">'.$products[$i]->Price.'</span>'.'<span class="stock">'.$products[$i]->Stock.'</span>'.'</li>';
            }
            echo '</ul><!-- .product-list -->';

        } else if ($listType == 'thumbnail' && $products!=NULL) {
            for ($i=0;$i<count($products); $i++){
                echo '<article class="product">';
                echo '  <img src="'.$products[$i]->ImgUrl.'" class="product-image"/>';
                echo '  <div class="product-meta">';
                echo '  <h2 class="product-title">'. $products[$i]->Name .'</h2>';
                echo '  <span class="product-price">'. $products[$i]->Price .'</span>';
                echo '  <div class="product-add-to-cart-button"></div>';
                echo '</div><!-- .product-meta -->';
                echo '</article>';
            }
        }else if($listType=="admin" && $products!=NULL){
            echo '<table id="table" class="tablesorter">';
            echo	'<thead>';
            echo	'	<tr class="row">';
            echo	'		<th class="col">Product Id</th>';
            echo	'		<th class="col">Product Name</th>';
            //echo	'		<th class="col">Description</th>';
            //echo	'		<th class="col">Image</th>';
            echo	'		<th class="col">Taxanomy</th>';
            echo	'		<th class="col">Price</th>';
            echo	'		<th class="col">Stock</th>';
            echo	'		<th class="col"></th>';
            echo	'	</tr>';
            echo	'</thead>';
            echo	'<tbody>';
            for ($i=0;$i<count($products);$i++) {
                echo	'<tr class="row">';
                echo	'	<td class="col">'.$products[$i]->ProductId.'</td>';
                echo	'	<td class="col">'.$products[$i]->Name.'</td>';
                //echo	'	<td class="col">'.$products[$i]->Description.'</td>';
                //echo	'	<td class="col">'.$products[$i]->Image.'</td>';
                echo	'	<td class="col">'.$products[$i]->Taxanomy.'</td>';
                echo	'	<td class="col">'.$products[$i]->Price.'</td>';
                echo	'	<td class="col">'.$products[$i]->Stock.'</td>';
                echo	'	<td class="col"><a href="/admin/products/'.$products[$i]->ProductId.'"/>Edit</a></td>';
                echo	'</tr>';
            }
            echo	'</tbody>';
            echo	'</table>';
        }else if($listType=="user" && $products!=NULL){
            echo '<section class="products">';
            for($i=0;$i<count($products);$i++){
                echo '<article class="product">';
                echo    '<a href="">';
                echo        '<img src="'.$products[$i]->ImgUrl.'" class="product-image"/>';
                echo    '</a>';
                echo    '<div class="product-meta">';
                echo	    '<h2 class="product-title">'.$products[$i]->Name.'</h2>';
                echo        '<span class="product-price">'.$products[$i]->Price.'</span>';
                echo        '<div class="product-add-to-cart-button">';
                echo             '<a href=""><img src="img/cart.png"></a>';
                echo        '</div>';
                echo    '</div><!-- .product-meta -->';
                echo '</article>';
            }
            echo '</section>';
        }else if($listType=="single" && $products!=NULL){
            echo '<section class="product">';
            echo    '<article class="product">';
		    echo        '<a href="">';
			echo			'<img src="'.$products[0]->ImgUrl.'" class="product-image"/>';
			echo	    '</a>';
			echo	'</article>';
			echo	'<div class="product-meta">';
			echo	    '<h2 class="product-title">'.$products[0]->Name.'</h2>';
			echo		'<div class="product-description">'.$products[0]->Description.'</div>';
			echo		'<span class="product-price">'.$products[0]->Price.'</span>';
			echo		'<div class="product-add-to-cart-button">';
			echo			'<a href=""><img src="img/cart.png"></a>';
			echo		'</div>';
			echo	'</div><!-- .product-meta -->';
			echo '</section>';
        }else{
            echo '<span class="error">No product found.</span>';
        }

    }

    function listOrders($listType){
        $numargs=func_num_args();
        $arg_list=func_get_args();
        $pass_arg_list=NULL;
        for($i=1,$j=0;$i<$numargs;$i++,$j++){
            $pass_arg_list[$j]=$arg_list[$i];
        }
        // Get a list of orders from database and save the array in $orders
        // Loop through array and add all Orders to $orders as a Order Class
        $orders=call_user_func_array("getOrders",$pass_arg_list);
        if($listType=="admin" && $orders!=NULL){
            echo '<table id="table" class="tablesorter">';
            echo	'<thead>';
            echo	'	<tr class="row">';
            echo	'		<th class="col">Order Id</th>';
            echo	'		<th class="col">SSNr</th>';
            echo	'		<th class="col">Order Date</th>';
            echo	'		<th class="col">Discount</th>';
            echo	'		<th class="col">Charged Card</th>';
            echo	'		<th class="col">Order IP</th>';
            echo	'		<th class="col">Product List</th>';
            echo	'		<th class="col"></th>';
            echo	'	</tr>';
            echo	'</thead>';
            echo	'<tbody>';
            for ($i=0;$i<count($orders);$i++){
                echo	'<tr class="row">';
                echo	'	<td class="col">'.$orders[$i]->OrderId.'</td>';
                echo	'	<td class="col">'.$orders[$i]->SSNr.'</td>';
                echo	'	<td class="col">'.$orders[$i]->OrderDate.'</td>';
                echo	'	<td class="col">'.$orders[$i]->Discount.'</td>';
                echo	'	<td class="col">'.$orders[$i]->ChargedCard.'</td>';
                echo	'	<td class="col">'.$orders[$i]->OrderIP.'</td>';
                echo	'	<td class="col">button for product lists</td>';
                echo	'	<td class="col"><a href="/admin/orders/'.$orders[$i]->OrderId.'"/>Edit</a></td>';
                echo	'</tr>';
            }
            echo	'</tbody>';
            echo	'</table>';
        }else if($listType=="userorders"){
            $orders=call_user_func_array("getUsersOrders",$pass_arg_list);
            echo '<table id="table" class="tablesorter">';
            echo	'<thead>';
            echo	'	<tr class="row">';
            echo	'		<th class="col">Order Id</th>';
            echo	'		<th class="col">SSNr</th>';
            echo	'		<th class="col">Order Date</th>';
            echo	'		<th class="col">Discount</th>';
            echo	'		<th class="col">Charged Card</th>';
            echo	'		<th class="col">Order IP</th>';
            echo	'		<th class="col">Product List</th>';
            echo	'		<th class="col"></th>';
            echo	'	</tr>';
            echo	'</thead>';
            echo	'<tbody>';
            for ($i=0;$i<count($orders);$i++) {
                echo	'<tr class="row">';
                echo	'	<td class="col">'.$orders[$i]->OrderId.'</td>';
                echo	'	<td class="col">'.$orders[$i]->SSNr.'</td>';
                echo	'	<td class="col">'.$orders[$i]->OrderDate.'</td>';
                echo	'	<td class="col">'.$orders[$i]->Discount.'</td>';
                echo	'	<td class="col">'.$orders[$i]->ChargedCard.'</td>';
                echo	'	<td class="col">'.$orders[$i]->OrderIP.'</td>';
                echo	'	<td class="col">button for product lists</td>';
                echo	'	<td class="col"><a href="/settings/orders/'.$orders[$i]->OrderId.'"/>Edit</a></td>';
                echo	'</tr>';
            }
            echo	'</tbody>';
            echo	'</table>';
        }else if($listType=='orderinfo'){
            echo '<table class="table">';
			echo	'<tr>';
			echo		'<td><strong>Order</strong></td>';
			echo		'<td>'.$orders[0]->OrderId.'</td>';
			echo	'</tr>';
			echo	'<tr>';
			echo		'<td><strong>Order date</strong></td>';
			echo		'<td>'.$orders[0]->OrderDate.'</td>';
			echo	'</tr>';
			echo '</table>';
			echo '<table class="table">';
			echo	'<tr>';
			echo	    '<th><strong>Shipping Address</strong></th>';
            echo	    '<th></th>';
			echo	    '<th><strong>Billing Address</strong></th>';
			echo	    '<th></th>';
			echo	'</tr>';
			echo	'<tr>';
			echo		'<td><strong>Street Address</strong></td>';
			echo		'<td>'.$orders[0]->StreetAddress.'</td>';
			echo		'<td>Street Address</td>';
			echo		'<td>'.$orders[0]->StreetAddress.'</td>';
			echo	'</tr>';
			echo	'<tr>';
			echo	    '<td>Post Address</td>';
			echo		'<td>'.$orders[0]->PostAddress.'</td>';
			echo		'<td>Post Address</td>';
			echo		'<td>'.$orders[0]->PostAddress.'</td>';
			echo	'</tr>';
			echo	'<tr>';
			echo	    '<td>City</td>';
			echo	    '<td>'.$orders[0]->City.'</td>';
			echo		'<td>City</td>';
			echo			'<td>'.$orders[0]->City.'</td>';
			echo		'</tr>';
			echo	'</table>';
			echo	'<table class="table">';
			echo		'<tr>';
			echo			'<th>Name</th>';
			echo			'<th>Weight</th>';
			echo			'<th>Price</th>';
			echo			'<th>Amount</th>';
			echo			'<th>Total Price</th>';
			echo		'</tr>';
            $totsum=0;
            $totweight=0;
            for($i=0;$i<count($orders[0]->ProductList);$i++){
                $totsum+=($orders[0]->ProductList[$i]->Amount*$orders[0]->ProductList[$i]->ProductPrice);
                $totweight+=($orders[0]->ProductList[$i]->Amount*$orders[0]->ProductList[$i]->ProductWeight);
                echo		'<tr>';
                echo			'<td>'.$orders[0]->ProductList[$i]->ProductName.'</td>';
                echo			'<td>'.$orders[0]->ProductList[$i]->ProductWeight.'</td>';
                echo			'<td>'.$orders[0]->ProductList[$i]->ProductPrice.'</td>';
                echo			'<td>'.$orders[0]->ProductList[$i]->Amount.'</td>';
                echo			'<td>'.$orders[0]->ProductList[$i]->Amount*$orders[0]->ProductList[$i]->ProductPrice.'</td>';
                echo		'</tr>';
            }
			echo		'<tr>';
			echo			'<td></td>';
			echo			'<td></td>';
			echo			'<td></td>';
			echo			'<td>Sum</td>';
			echo			'<td>'.$totsum.' kr</td>';
			echo		'</tr>';
			echo	'<tr>';
			echo			'<td></td>';
			echo			'<td></td>';
			echo			'<td></td>';
			echo			'<td>Total Weight</td>';
			echo			'<td>'.$totweight.' kg</td>';
			echo		'</tr>';
			echo		'<tr>';
			echo			'<td></td>';
			echo			'<td></td>';
			echo			'<td></td>';
			echo			'<td>Shipping Cost</td>';
			echo			'<td>150 kr</td>';
			echo		'</tr>';
            $totsum+=150;
			echo		'<tr>';
			echo			'<td></td>';
			echo			'<td></td>';
			echo			'<td></td>';
			echo			'<td>Total value of order</td>';
			echo			'<td>'.$totsum.' kr</td>';
			echo	'</tr>';
			echo	'<tr>';
			echo			'<td></td>';
			echo			'<td></td>';
			echo			'<td></td>';
			echo			'<td>Total value of order including VAT</td>';
			echo			'<td><strong>'.$totsum.' kr</strong></td>';
			echo		'</tr>';
			echo	'</table>';
        }else{
            echo '<span class="error">No orders found.</span>';
        }
    }
    function listUsers($listType){
        $numargs=func_num_args();
        $arg_list=func_get_args();
        $pass_arg_list=NULL;
        for($i=1,$j=0;$i<$numargs;$i++,$j++){
            $pass_arg_list[$j]=$arg_list[$i];
        }
        $users=call_user_func_array("getUsers",$pass_arg_list);
        if($listType=="admin" && $users!=NULL){
            echo '<table id="table" class="tablesorter">';
            echo	'<thead>';
            echo	'	<tr class="row">';
            echo	'		<th class="col">Social Security Number</th>';
            echo	'		<th class="col">Full Name</th>';
            echo	'		<th class="col"></th>';
            echo	'	</tr>';
            echo	'</thead>';
            echo	'<tbody>';
            for ($i=0;$i<count($users);$i++) {
                echo	'<tr class="row">';
                echo	'	<td class="col">'.$users[$i]->SSNr.'</td>';
                echo	'	<td class="col">'.$users[$i]->FirstName." ".$users[$i]->LastName.'</td>';
                echo	'	<td class="col"><a href="/admin/users/'.$users[$i]->SSNr.'"/>Edit</a></td>';
	            echo	'</tr>';
            }
            echo	'</tbody>';
            echo	'</table>';
        }else{
            echo '<span class="error">No users found.</span>';
        }
    }
    function listProductsFromTaxanomy($listType){
        $numargs=func_num_args();
        $arg_list=func_get_args();
        $pass_arg_list=NULL;
        for($i=1,$j=0;$i<$numargs;$i++,$j++){
            $pass_arg_list[$j]=$arg_list[$i];
        }
        $taxanomies=call_user_func_array("getProductsFromTaxanomy",$pass_arg_list);
        if($listType=="admin" && $taxanomies!=NULL){
            echo '<table id="table" class="tablesorter">';
            echo	'<thead>';
            echo	'	<tr class="row">';
            echo	'		<th class="col">Product Id</th>';
            echo	'		<th class="col">Product Name</th>';
            //echo	'		<th class="col">Description</th>';
            //echo	'		<th class="col">Image</th>';
            echo	'		<th class="col">Taxanomy</th>';
            echo	'		<th class="col">Price</th>';
            echo	'		<th class="col">Stock</th>';
            echo	'		<th class="col"></th>';
            echo	'	</tr>';
            echo	'</thead>';
            echo	'<tbody>';
            for ($i=0;$i<count($taxanomies);$i++) {
                echo	'<tr class="row">';
                echo	'	<td class="col">'.$taxanomies[$i]->ProductId.'</td>';
                echo	'	<td class="col">'.$taxanomies[$i]->Name.'</td>';
                //echo	'	<td class="col">'.$taxanomies[$i]->Description.'</td>';
                //echo	'	<td class="col">'.$taxanomies[$i]->Image.'</td>';
                echo	'	<td class="col">'.$taxanomies[$i]->Taxanomy.'</td>';
                echo	'	<td class="col">'.$taxanomies[$i]->Price.'</td>';
                echo	'	<td class="col">'.$taxanomies[$i]->Stock.'</td>';
                echo	'	<td class="col"><a href="/admin/taxanomies/'.$taxanomies[$i]->ProductId.'"/>Edit</a></td>';
                echo	'</tr>';
            }
            echo	'</tbody>';
            echo	'</table>';
        }else{
            echo '<span class="error">No taxanomies found.</span>';
        }
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
        $data=dbGetProduct($ProductId);
        $product=NULL;
        if($data!=NULL){
            $products=new Product($data['ProductId'],$data['Name'],$data['Description'],$data['ImgUrl'],$data['Taxanomy'],$data['Price'],$data['Stock'],$data['ProductWeight']);
        }
        return $product;
    }
    function getAllProducts(){
        global $db;
        $data=dbGetProductsAll();
        $products=NULL;
        for($i=0;$i<count($data);$i++){
            $products[$i]=new Product($data[$i]['ProductId'],$data[$i]['Name'],$data[$i]['Description'],$data[$i]['ImgUrl'],$data[$i]['Taxanomy'],$data[$i]['Price'],$data[$i]['Stock'],$data[$i]['ProductWeight']);
        }
        return $products;
    }
    function getProductsFromTaxanomy($TaxanomyId){
        global $db;
        $data=dbGetProductsFromTaxanomy($TaxanomyId);
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
        $data=dbGetOrder($OrderId);

        $order=NULL;
        if($data!=NULL){
            $order=new Order($data['OrderId'],$data['SSNr'],$data['OrderDate'],$data['Discount'],$data['ChargedCard'],$data['OrderIP'],$data['ProductList']);
        }
        return $order;
    }
    function getAllOrders() { // Returns an order from the order as an Order class.
        global $db;
        $data=dbGetOrdersAll();
        $orders=NULL;
        for($i=0;$i<count($data);$i++){
            $orders[$i]=new Order($data[$i]['OrderId'],$data[$i]['SSNr'],$data[$i]['OrderDate'],$data[$i]['Discount'],$data[$i]['ChargedCard'],$data[$i]['OrderIP'],NULL);
        }
        return $orders;
    }
    function getUsersOrders($SSNr) { // Returns an order from the order as an Order class.
        global $db;
        $data=dbGetUsersOrders($SSNr);
        $orders=NULL;
        for($i=0;$i<count($data);$i++){
            $orders[$i]=new Order($data[$i]['OrderId'],$data[$i]['SSNr'],$data[$i]['OrderDate'],$data[$i]['Discount'],$data[$i]['ChargedCard'],$data[$i]['OrderIP'],NULL);
        }
        return $orders;
    }
    // END ORDER ----------------------------------|


?>