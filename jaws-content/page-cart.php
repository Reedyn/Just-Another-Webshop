<?php jaws_header();
if(!isset($_SESSION['cart']) || count($_SESSION['cart']['items']) == 0){
    registerError("Your cart is empty", "warning");
    redirect("/");
}
if(!isLoggedIn()){ // Prompt user to login when trying
    loginPrompt("Please login to checkout your shopping cart", "warning");
}

if(isset($_POST['cart-remove']) && isset($_SESSION['cart']['items'][$_POST['cart-remove']])){ // Remove item from cart when button is pressed.
    unset($_SESSION['cart']['items'][$_POST['cart-remove']]);
    registerError("Item removed from cart","success");
    redirect();
}

if(isset($_POST['cart-update'])){ // Update cart when button is pressed.
    foreach($_POST as $key => $value){ 
        if(isset($_SESSION['cart']['items'][$key])) {
            $_SESSION['cart']['items'][$key]['amount'] = $value;
        }
    }
    registerError("Cart updated","success");
    redirect();
}
if(isset($_POST['review-order'])){ // If user is trying to checkout
    if(isset($_POST['shipping-street-address']) &&
       isset($_POST['billing-street-address']) &&
       isset($_POST['shipping-post-address']) &&
       isset($_POST['billing-post-address']) &&
       isset($_POST['shipping-city']) &&
       isset($_POST['billing-city']) &&
       isset($_POST['card-full-name']) &&
       isset($_POST['card-expiry-month']) && $_POST['card-expiry-month'] != "false" &&
       isset($_POST['card-expiry-year']) && $_POST['card-expiry-year'] != "false" &&
       isset($_POST['card-number']) && preg_match("$((4\d{3})|(5[1-5]\d{2})|(6011))-?\s?\d{4}-?\s?\d{4}-?\s?\d{4}|3[4,7]\d{13}$", $_POST['card-number']) &&
       isset($_POST['card-cvc']) &&  preg_match("$\d{3}$", $_POST['card-cvc'])){
        $remove = array("-", " ");
        $_POST['card-number'] = str_replace($remove, "", $_POST['card-number']);
        $_SESSION['form']['cart']['shipping-street-address'] = $_POST['shipping-street-address'];
        $_SESSION['form']['cart']['billing-street-address' ] = $_POST['billing-street-address'];
        $_SESSION['form']['cart']['shipping-post-address' ] = $_POST['shipping-post-address'];
        $_SESSION['form']['cart']['billing-post-address' ] = $_POST['billing-post-address'];
        $_SESSION['form']['cart']['shipping-city' ] = $_POST['shipping-city'];
        $_SESSION['form']['cart']['billing-city' ] = $_POST['billing-city'];
        $_SESSION['form']['cart']['card-full-name' ] = $_POST['card-full-name'];
        $_SESSION['form']['cart']['card-expiry-month' ] = $_POST['card-expiry-month'];
        $_SESSION['form']['cart']['card-expiry-year' ] = $_POST['card-expiry-year'];
        $_SESSION['form']['cart']['card-number' ] = $_POST['card-number'];
        $_SESSION['form']['cart']['card-cvc' ] = $_POST['card-cvc'];
        redirect("/cart/review/");
    } else {
        $_SESSION['form']['cart']['shipping-street-address'] = $_POST['shipping-street-address'];
        $_SESSION['form']['cart']['billing-street-address' ] = $_POST['billing-street-address'];
        $_SESSION['form']['cart']['shipping-post-address' ] = $_POST['shipping-post-address'];
        $_SESSION['form']['cart']['billing-post-address' ] = $_POST['billing-post-address'];
        $_SESSION['form']['cart']['shipping-city' ] = $_POST['shipping-city'];
        $_SESSION['form']['cart']['billing-city' ] = $_POST['billing-city'];
        $_SESSION['form']['cart']['card-full-name' ] = $_POST['card-full-name'];
        $_SESSION['form']['cart']['card-expiry-month' ] = $_POST['card-expiry-month'];
        $_SESSION['form']['cart']['card-expiry-year' ] = $_POST['card-expiry-year'];
        $_SESSION['form']['cart']['card-number' ] = $_POST['card-number'];
        $_SESSION['form']['cart']['card-cvc' ] = $_POST['card-cvc'];
        registerError("You need to fill in all fields to continue","warning");
        redirect();
    }
    
                     
}
                  
?>
<div class="panel panel-primary">
    <div class="panel-heading ">Check your cart</div>
    <div class="panel-body">
    <?php
        listCart();
    ?>
    
    </div>
    <div id="div1">
        <div class="panel-heading">Personal information</div>
        <div class="panel-body">
        <?php
            listPersonalInfo();
        ?>
        </div>
    </div>
</div>


<?php jaws_footer(); ?>