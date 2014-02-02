<?php jaws_header(); 

if(!isset($_SESSION['cart'])){
    registerError("Your cart is empty, please add a product before trying to checkout", "warning");
    redirect("/");
}

if(isset($_POST['place-order'])){ // Ff user has pressed place order.
    try { // Try to add card to database, save the returned ID in variable $card
        $card = $GLOBALS['db']->dbAddCard($_SESSION['form']['cart']['card-number'],$_SESSION['form']['cart']['card-full-name'],$_SESSION['form']['cart']['card-expiry-month'],$_SESSION['form']['cart']['card-expiry-year']);
    } catch (Exception $e) {
        $card = false;
    }
    if($card){ // If card was successfully added, Maybe we can do this as a part of the dbAddOrder function instead?
        if($db->dbAddOrder($_SESSION['loginSSNr'],0,$card,shoppingCart())){ // try to add order to database
            unset($_SESSION['cart']);
            unset($_SESSION['form']);
            registerError("Thank you for your order! You can see your orders here","success");
            redirect("/settings/orders/");
        } else { // If order couldn't be placed, reload the page with an error.
            registerError("Something went wrong when trying to place your order","danger");
            redirect();
        }
    }
      
}
    ?>

<div class="panel panel-primary">
    <div class="panel-heading ">Review your information before placing order</div>
    <div class="panel-body">
    <?php
        listReview();
    ?>
    
    </div>
</div>

<?php jaws_footer(); ?>