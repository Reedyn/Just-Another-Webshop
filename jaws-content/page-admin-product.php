<?php jaws_header();
if (!isAdmin()){
    loginPrompt("You need to be an administrator to access this page.");
}
    if (isset($_POST['product-add'])){
        if (isset($_POST['product-name']) && preg_match("$.+$", $_POST['product-name']) &&
            isset($_POST['product-description']) && preg_match("$.+$", $_POST['product-description']) &&
            isset($_POST['product-price']) && preg_match("$.+$", $_POST['product-price']) &&
            isset($_POST['product-stock']) && preg_match("$.+$", $_POST['product-stock']) &&
            isset($_POST['product-weight']) && preg_match("$.+$", $_POST['product-weight']) &&
            isset($_POST['product-stock']) && preg_match("$.+$", $_POST['product-stock']) &&
            isset($_POST['product-category']) && preg_match("$.+$", $_POST['product-category']) &&
            isset($_FILES['product-image'])){
            
            require_once($_SERVER['DOCUMENT_ROOT'].'/jaws-includes/image-resizer.php');
            // array of valid extensions
            $validExtensions = array('.jpg','.jpeg');
            // get extension of the uploaded file
            $fileExtension = strrchr($_FILES['product-image']['name'], ".");
            // check if file Extension is on the list of allowed ones
            if (in_array($fileExtension, $validExtensions)) {
                $manipulator = new ImageManipulator($_FILES['product-image']['tmp_name']);
                $newImage = $manipulator->resample(200, 200);
                // saving file to uploads folder
                $manipulator->save($_SERVER['DOCUMENT_ROOT'].'/img/' . $_FILES['product-image']['name']);
                if($db->dbAddProduct($_POST['product-name'],$_POST['product-description'],'/img/'.$_FILES['product-image']['name'],$_POST['product-category'],$_POST['product-price'],$_POST['product-stock'],$_POST['product-weight'])) {
                    registerError('Product added successfully','success');
                    redirect("/admin/products/");
                }else{
                    registerError("Product couldn't be saved to database",'danger');
                    redirect($_SERVER[HTTP_REQUEST_URl]);
                }
            } else {
                showError('Problem while uploading file',"danger");
            }       
        } else {
            showError('Adding product failed',"danger");
            var_dump($_FILES);
            var_dump($_POST);
        }
    } else if (isset($_POST['product-edit'])){
        if (isset($_POST['product-name']) && preg_match("$.+$", $_POST['product-name']) &&
            isset($_POST['product-description']) && preg_match("$.+$", $_POST['product-description']) &&
            isset($_POST['product-price']) && preg_match("$.+$", $_POST['product-price']) &&
            isset($_POST['product-stock']) && preg_match("$.+$", $_POST['product-stock']) &&
            isset($_POST['product-weight']) && preg_match("$.+$", $_POST['product-weight']) &&
            isset($_POST['product-stock']) && preg_match("$.+$", $_POST['product-stock']) &&
            isset($_POST['product-category']) && preg_match("$.+$", $_POST['product-category'])){
            
            if(isset($_FILES['product-image']) && !empty($_FILES['product-image']['name'])) {
                echo $_FILES['product-image']['name'];
                require_once($_SERVER['DOCUMENT_ROOT'].'/jaws-includes/image-resizer.php');
                $validExtensions = array('.jpg','.jpeg');
                $fileExtension = strrchr($_FILES['product-image']['name'], ".");
                if (in_array($fileExtension, $validExtensions)) {
                    $manipulator = new ImageManipulator($_FILES['product-image']['tmp_name']);
                    $newImage = $manipulator->resample(200, 200);
                    $manipulator->save($_SERVER['DOCUMENT_ROOT'].'/img/' . $_FILES['product-image']['name']);
                    if($db->dbEditProduct($_POST['product-id'],
                        "Name",$_POST['product-name'],
                        "Description",$_POST['product-description'],
                        "ImgUrl",'/img/'.$_FILES['product-image']['name'],
                        "Taxanomy",$_POST['product-category'],
                        "Price",$_POST['product-price'],
                        "Stock",$_POST['product-stock'],
                        "ProductWeight",$_POST['product-weight'])) {
                        
                        registerError('Product edited successfully','success');
                        redirect($_SERVER['REQUEST_URI']);
                    }else{
                        registerError("Product couldn't be saved to database",'danger');
                        redirect($_SERVER['REQUEST_URI']);
                    }
                } else {
                    showError('Problem while uploading file',"danger");
                }
            } else {
                if($db->dbEditProduct($_POST['product-id'],
                        "Name",$_POST['product-name'],
                        "Description",$_POST['product-description'],
                        "Taxanomy",$_POST['product-category'],
                        "Price",$_POST['product-price'],
                        "Stock",$_POST['product-stock'],
                        "ProductWeight",$_POST['product-weight'])) {
                    registerError('Product edited successfully','success');
                    redirect($_SERVER['REQUEST_URI']);
                }else{
                    registerError("Product couldn't be saved to database",'danger');
                    //redirect($_SERVER['REQUEST_URI']);
                }
            }  
        } else {
            showError('Product save failed',"danger");
            var_dump($_FILES);
            var_dump($_POST);
        }
    }else if (isset($_POST['product-delete'])){
        if($db->dbDeleteProduct($_POST['product-id'])){
            registerError("Product deleted",'success');
            redirect("/admin/products");
        } else {
            registerError("Product couldn't be deleted",'danger');
            redirect($_SERVER['REQUEST_URI']);
        }
    }
    ?>
<?php listAdminSingleProduct($_GET['product']); ?>      

<?php jaws_footer(); ?>