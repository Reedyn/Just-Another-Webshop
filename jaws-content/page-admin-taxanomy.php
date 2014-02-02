<?php jaws_header();

if(isset($_POST['taxanomy-add'])){
    if($db->dbAddTaxanomy($_POST['taxanomy-name'],$_POST['taxanomy-parent'])){
        registerError("Category added","success");
        redirect();
    } else {
        registerError("Category couldn't be added","danger");
        redirect();
    }
}

if(isset($_POST['taxanomy-delete'])){
    if($db->dbAddTaxanomy($_GET['category'])){
        registerError("Category deleted","success");
        redirect("/admin/categories/");
    } else {
        registerError("Category couldn't be deleted","danger");
        redirect();
    }
}

if(isset($_POST['taxanomy-edit'])){
    if($db->dbEditTaxanomy($_POST['taxanomy-id'],"CurrencyMultiplier",$_POST['currency-value'],"CurrencyName",$_POST['currency-name'],"CurrencySign",$_POST['currency-sign'],"CurrencyLayout",$_POST['currency-position'])){
        registerError("Category successfully edited","success");
        redirect();
    } else {
        registerError("Category couldn't be edited","danger");
        redirect();
    }
} ?>


<?php listAdminSingleTaxanomy(); ?>


<?php jaws_footer(); ?>