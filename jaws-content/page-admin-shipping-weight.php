<?php 
if(isset($_POST['shipping-add'])){//dbAddShipping($MaxWeight,$Price)
    if($GLOBALS['db']->dbAddShipping($_POST['shipping-max-weight'],$_POST['shipping-cost'])){
        registerError("Shipping weight successfully added","success");
        redirect();
    } else {
        registerError("Error adding weight","success");
        redirect();
    }
}

if(isset($_POST['shipping-edit'])){//dbAddShipping($MaxWeight,$Price)
    if($GLOBALS['db']->dbEditShipping($_POST['shipping-max-weight'],"Price",$_POST['shipping-cost'])){
        registerError("Package Weight successfully edited","success");
        redirect();
    } else {
        registerError("Error editing weight","success");
        redirect();
    }
}

if(isset($_POST['shipping-edit'])){//dbAddShipping($MaxWeight,$Price)
    if($GLOBALS['db']->dbDeleteShipping($_POST['shipping-max-weight'])){
        registerError("Package Weight successfully deleted","success");
        redirect("/admin/shipping/");
    } else {
        registerError("Error editing weight","success");
        redirect();
    }
}
jaws_header(); ?>

<?php listAdminSinglePackage(); ?>

<?php jaws_footer(); ?>