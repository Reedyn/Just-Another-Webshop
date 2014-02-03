<?php 
if(isset($_POST['currency-add'])){
    if($db->dbAddCurrency($_POST['currency-name'],$_POST['currency-value'],$_POST['currency-sign'],$_POST['currency-position'])){
        registerError("Currency added","success");
        redirect();
    } else {
        registerError("Currency couldn't be added","danger");
        redirect();
    }
}

if(isset($_POST['currency-delete'])){
    if($db->dbDeleteCurrency($_POST['currency-id'])){
        registerError("Currency deleted","success");
        redirect("/admin/currencies/");
    } else {
        registerError("Currency couldn't be deleted","danger");
        redirect();
    }
}

if(isset($_POST['currency-edit'])){
    if($db->dbEditCurrency($_POST['currency-id'],"CurrencyMultiplier",$_POST['currency-value'],"CurrencyName",$_POST['currency-name'],"CurrencySign",$_POST['currency-sign'],"CurrencyLayout",$_POST['currency-position'])){
        registerError("Currency successfully edited","success");
        redirect();
    } else {
        registerError("Currency couldn't be edited","danger");
        redirect();
    }
}

jaws_header();?>

<?php listAdminSingleCurrency(); ?>

<?php jaws_footer(); ?>