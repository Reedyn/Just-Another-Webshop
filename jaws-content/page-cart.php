<?php jaws_header();
if(!isLoggedIn()){ // Prompt user to login when trying
    loginPrompt("Please login to checkout your shopping cart");
}

if(isset($_POST['cart-remove']) && isset($_SESSION['cart'][$_POST['cart-remove']])){ // Remove item from cart when button is pressed.
    unset($_SESSION['cart'][$_POST['cart-remove']]);
    registerError("Item removed from cart","success");
    header('Location: '.$_SERVER['REQUEST_URI']);
    exit();
}

if(isset($_POST['currency']) && !isset($_POST['cart-update'])){ // Set new currency when a new currency is selected.
    $id = intval($_POST['currency']);
    // $db->getCurrency();
    setCurrency($id,"Swedish crowns","kr", "suffix",0.113082696);
    registerError("Currency changed","success");
    redirect();
    
}

if(isset($_POST['cart-update'])){ // Update cart when button is pressed.
    foreach($_POST as $key => $value){ 
        if(isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key] = $value;
        }
    }
    registerError("Cart updated","success");
    redirect();
}
if(isset($_POST['checkout'])){ // If user is trying to checkout
    $remove = array("-", " ");
    $_POST['card-number'] = str_replace($remove, "", $_POST['card-number']);                  
}
                  
?>
      <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading ">Step 1 - Check your cart</div>
        <div class="panel-body">
            <?php
                listCart();
            ?>

      </div>

      <div class="panel-heading ">Step 2 - Payment method</div>
      <div class="panel-body">
       <input type="radio" name="c1" onclick="showMe('div1')">Credit Card

     </div>
     <div id="div1">
       <div class="panel-heading">Step 3 - Personal information</div>
       <div class="panel-body">
           <?php
                listPersonalInfo();
           ?>
    </div>
  </div>
</div>


<?php jaws_footer(); ?>