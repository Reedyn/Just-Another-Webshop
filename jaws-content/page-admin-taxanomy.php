<?php jaws_header();

if(isset($_POST['taxanomy-add'])){
    if($_POST['taxanomy-parent'] == "false"){
        $_POST['taxanomy-parent'] = 1;
    }
    if($db->dbAddTaxanomy($_POST['taxanomy-name'],$_POST['taxanomy-parent'])){
        registerError("Category added","success");
        redirect();
    } else {
        registerError("Category couldn't be added","danger");
        redirect();
    }
}

if(isset($_POST['taxanomy-delete'])){
    if($db->dbDeleteTaxanomy($_GET['category'])){
        registerError("Category deleted","success");
        redirect("/admin/categories/");
    } else {
        registerError("Category couldn't be deleted","danger");
        redirect();
    }
}

if(isset($_POST['taxanomy-edit'])){
    $_POST['taxanomy-parent'] = intval($_POST['taxanomy-parent']);
    if($db->dbEditTaxanomy($_POST['taxanomy-id'],"TaxanomyName",$_POST['taxanomy-name'],"TaxanomyParent",$_POST['taxanomy-parent'])){
        registerError("Category successfully edited","success");
        redirect();
    } else {
        registerError("Category couldn't be edited","danger");
        redirect();
    }
} ?>


<?php listAdminSingleTaxanomy(); ?>


<?php jaws_footer(); ?>