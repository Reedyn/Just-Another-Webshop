<?php
public function listProducts($category,$listType){ // List products in the fashion specified.
    // Get a list of products from database and save the array in $products
    
    if ($listType == 'list') {
        echo '<ul class="product-list">';
        for ($i = 0; i < $products.length(); i++){
            echo '  <li>' . '<span class="name">' . $products[i]->Name . '</span>' . '<span class="price">' . $products[i]->price . '</span>' . '<span class="stock">' . $products[i]->stock . '</span>' . '</li>'
        }
        echo '</ul><!-- .product-list -->'
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


?>