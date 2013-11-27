<?php
    //Includes
    include 'db.php';
    include 'config.php';

    //Initialize the class Database
    $db=new Database($dbHost,$dbUser,$dbPassword,$dbName);
    //Functions



public function listProducts($category,$listType){ // List products in the fashion specified.
    // Get a list of products from database and save the array in $products
    //Loop through array and add all products to $products as a Product Class
    $numargs=func_num_args();
    $arg_list=func_get_args();
    $pass_arg_list=NULL;
    $j=0;
    for($i=2,$j=0;$i<$numargs;$i++){
        $pass_arg_list[$j]=$arg_list[$i];
        $j++;
    }
    
    $products=call_user_func_array(($this->db,"dbGetProducts()"),$pass_arg_list;)
    
    if ($listType == 'list') {
        echo '<ul class="product-list">';
        for ($i = 0; $i<$products.length(); $i++){
            echo '  <li>'.'<span class="name">'.$products[$i]->Name.'</span>'.'<span class="price">'.$products[$i]->price.'</span>'.'<span class="stock">'.$products[$i]->stock.'</span>'.'</li>'
        }
        echo '</ul><!-- .product-list -->';
    } elseif ($listType == 'thumbnail') {
        for ($i = 0; i < $products.length(); i++)
            echo '<article class="product">';
            echo '  <img src="'.$products[i]->imageUrl.'" class="product-image"/>';
            echo '  <div class="product-meta">';
            echo '  <h2 class="product-title">'. $product[i]->Name .'</h2>';
            echo '  <span class="product-price">'. $products[i]->price .'</span>';
            echo '  <div class="product-add-to-cart-button"></div>';
            echo '</div><!-- .product-meta -->';
            echo '</article>';
    } else {
        echo '<span class="error">No products found.</span>'
    } 
}

public function listOrders();
    // Get a list of orders from database and save the array in $products
    // Loop through array and add all Orders to $orders as a Order Class
    if ($listType == 'list') {
        echo '<ul class="order-list">';
        for ($i = 0; i < $orders.length(); i++){
            echo '  <li>' . '<span class="name">' . $orders[i]->Name . '</span>' . '<span class="price">' . $orders[i]->price . '</span>' . '<span class="stock">' . $orders[i]->stock . '</span>' . '</li>'
        }
        echo '</ul><!-- .product-list -->'
    }
?>