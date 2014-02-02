<?php jaws_header(); 

if(!isset($_SESSION['cart'])){
    registerError("Your cart is empty, please add a product before trying to checkout", "warning");
    redirect("/");
}
/*
public function dbAddOrder2($ChargedCard,$SSNr,$OrderIP,$OrderList){
            $time=$this->dbGetUnixTime();
            $this->autocommit(false);
            $status=FALSE;
            if($this->dbAddCard($ChargedCard['nr'],$ChargedCard['fullname'],$ChargedCard['expmonth'],$ChargedCard['expyear'])===TRUE){
*/
if(isset($_POST['place-order'])){
    $card = array(
        "nr" => $_SESSION['form']['cart']['card-number'],
        "fullname" => $_SESSION['form']['cart']['card-full-name'],
        "expmonth" => $_SESSION['form']['cart']['card-expiry-year'],
        "expyear" => $_SESSION['form']['cart']['card-expiry-month']
    );
    var_dump($card);
    var_dump(shoppingCart());
    if($db->dbAddOrder2($card, $_SESSION['LoginSSNr'],$_SERVER['REMOTE_ADDR'],shoppingCart())){ // try to add order to database
        unset($_SESSION['cart']);
        unset($_SESSION['form']);
        registerError("Thank you for your order! You can see your orders here","success");
        redirect("/settings/orders/");
    } else { // If order couldn't be placed, reload the page with an error.
        registerError("Something went wrong when trying to place your order","danger");
        //redirect();
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