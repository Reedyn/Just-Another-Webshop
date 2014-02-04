<?php 
    if (isset($_POST['product-add'])){
        if (isset($_POST['product-name']) && preg_match("$.+$", $_POST['product-name']) &&
            isset($_POST['product-description']) && preg_match("$.+$", $_POST['product-description']) &&
            isset($_POST['product-price']) && preg_match("$.+$", $_POST['product-price']) &&
            isset($_POST['product-stock']) && preg_match("$.+$", $_POST['product-stock']) &&
            isset($_POST['product-weight']) && preg_match("$.+$", $_POST['product-weight']) &&
            isset($_POST['product-stock']) && preg_match("$.+$", $_POST['product-stock']) &&
            isset($_POST['product-category']) && preg_match("$.+$", $_POST['product-category']) &&
            isset($_FILES['product-image'])){
            
            require_once($_SERVER['DOCUMENT_ROOT'].'/core/image-resizer.php');
            // array of valid extensions
            $validExtensions = array('.jpg','.jpeg');
            // get extension of the uploaded file
            $fileExtension = strrchr($_FILES['product-image']['name'], ".");
            // check if file Extension is on the list of allowed ones
            if (in_array($fileExtension, $validExtensions)) {
                $manipulator = new ImageManipulator($_FILES['product-image']['tmp_name']);
                $newImage = $manipulator->resample(200, 200);
                // saving file to uploads folder
                $manipulator->save($_SERVER['DOCUMENT_ROOT'].'/content/img/' . $_FILES['product-image']['name']);
                if($db->dbAddProduct($_POST['product-name'],$_POST['product-description'],'/content/img/'.$_FILES['product-image']['name'],$_POST['product-category'],$_POST['product-price'],$_POST['product-stock'],$_POST['product-weight'])) {
                    registerError('Product added successfully','success');
                    redirect("/admin/products/");
                }else{
                    registerError("Product couldn't be saved to database",'danger');
                    redirect();
                }
            } else {
                registerError('Problem while uploading file',"danger");
                redirect();
            }       
        } else {
            registerError('Adding product failed',"danger");
            redirect();
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
                require_once($_SERVER['DOCUMENT_ROOT'].'/core/image-resizer.php');
                $validExtensions = array('.jpg','.jpeg');
                $fileExtension = strrchr($_FILES['product-image']['name'], ".");
                if (in_array($fileExtension, $validExtensions)) {
                    $manipulator = new ImageManipulator($_FILES['product-image']['tmp_name']);
                    $newImage = $manipulator->resample(200, 200);
                    $manipulator->save($_SERVER['DOCUMENT_ROOT'].'/content/img/' . $_FILES['product-image']['name']);
                    if($db->dbEditProduct($_POST['product-id'],
                        "Name",$_POST['product-name'],
                        "Description",$_POST['product-description'],
                        "ImgUrl",'/content/img/'.$_FILES['product-image']['name'],
                        "Taxanomy",$_POST['product-category'],
                        "Price",$_POST['product-price'],
                        "Stock",$_POST['product-stock'],
                        "ProductWeight",$_POST['product-weight'])) {
                        
                        registerError('Product edited successfully','success');
                        redirect();
                    }else{
                        registerError("Product couldn't be saved to database",'danger');
                        redirect();
                    }
                } else {
                    registerError('Problem while uploading file',"danger");
                    redirect();
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
                    redirect();
                }else{
                    registerError("Product couldn't be saved to database",'danger');
                    redirect();
                }
            }  
        } else {
            registerError('Product save failed',"danger");
            redirect();
        }
    }else if (isset($_POST['product-delete'])){
        if($db->dbDeleteProduct($_POST['product-id'])){
            registerError("Product deleted",'success');
            redirect("/admin/products");
        } else {
            registerError("Product couldn't be deleted. Most likely is still active in some orders, delete those first",'danger');
            redirect();
        }
    }
    includeHeader(); ?>
    
<?php listAdminSingleProduct($_GET['product']); ?>      

<?php includeFooter(); ?>