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
        if ($listType == 'list') {
            echo '<ul class="order-list">';
            for ($i=0;$i<count($orders);$i++){
                echo '  <li>'.'<span class="name">'.$orders[$i]->Name.'</span>'.'<span class="price">'.$orders[$i]->Price.'</span>'.'<span class="stock">'.$orders[$i]->Stock.'</span>'.'</li>';
            }
            echo '</ul><!-- .product-list -->';
        }
    }
    function listUsers($listType){
        $numargs=func_num_args();
        $arg_list=func_get_args();
        for($i=1,$j=0;$i<$numargs;$i++,$j++){
            $pass_arg_list[$j]=$arg_list[$i];
        }
        $users=call_user_func_array(array($this,"getUsers()"),$pass_arg_list);
        if($listType=="list"){
            echo '<ul class="user-list">';
            for($i=0;$i<count($users);$i++){

            }
        }
    }
?>