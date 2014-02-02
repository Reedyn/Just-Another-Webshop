<?php jaws_header(); 

if(!isset($_SESSION['cart'])){
    registerError("Your cart is empty, please add a product before trying to checkout", "warning");
    redirect("/");
}

if(isset($_POST['place-order'])){   
    try {
        $card = $GLOBALS['db']->dbAddCard($_SESSION['form']['cart']['card-number'],$_SESSION['form']['cart']['card-full-name'],$_SESSION['form']['cart']['card-expiry-month'],$_SESSION['form']['cart']['card-expiry-year']);
    } catch (Exception $e) {
        $card = false;
    }
    if($card){
            //  dbAddOrder($SSNr,$Discount,$ChargedCard)
        if($db->dbAddOrder($_SESSION['loginSSNr'],0,$card,8,3,9,1)){ // try to add order to database
            unset($_SESSION['cart']);
            registerError("Thank you for your order! You can see your orders here","success");
            redirect("/settings/orders/");
        } else {
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