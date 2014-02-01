<?php jaws_header(); 

if(!isset($_SESSION['cart'])){
    registerError("Your cart is empty, please add a product before trying to checkout", "warning");
    redirect("/");
}
      
if(isset($_POST['place-order'])){
    if($GLOBALS['db']->dbAddOrder($_SESSION['loginSSNr'],0,$ChargedCard,$OrderIP)){ // try to add order to database
        unset($_SESSION['cart']);
        registerError("Thank you for your order! You can see your orders here","success");
        redirect("/settings/orders/");
    } else {
        registerError("Something went wrong when trying to place your order","danger");
        redirect();
    }   
}
    ?>

<div class="panel panel-primary">
    <div class="panel-heading ">Check your cart</div>
    <div class="panel-body">
    <?php
        listCart("review");
    ?>
    
    </div>
    <div id="div1">
        <div class="panel-heading">Personal information</div>
        <div class="panel-body">
        <?php
            listPersonalInfo("review");
        ?>
        </div>
    </div>
</div>

<?php jaws_footer(); ?>