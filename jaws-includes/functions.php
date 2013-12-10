<?php
    include 'class-product.php';
    include 'class-order.php';
    include 'class-user.php';

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

        } else if ($listType == 'thumbnail') {
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
        }else {
            echo '<span class="error">No products found.</span>';
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
        $orders=call_user_func_array(array($this,"getOrders()"),$pass_arg_list);
        if($listType=="table" && $orders!=NULL){
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
                echo	'	<td class="col"><a href="/admin/orders/'.$orders[$i]->OrderId.'"/>Edit</a></td>';
                echo	'</tr>';
            }
            echo	'</tbody>';
            echo	'</table>';
        }else{
            echo 'Nothing found';
        }
    }
    function listUsers($listType){
        $numargs=func_num_args();
        $arg_list=func_get_args();
        $pass_arg_list=NULL;
        for($i=1,$j=0;$i<$numargs;$i++,$j++){
            $pass_arg_list[$j]=$arg_list[$i];
        }
        $users=call_user_func_array(array($this,"getUsers()"),$pass_arg_list);
        if($listType=="table" && $users!=NULL){
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
            echo 'Nothing found';
        }
    }
?>