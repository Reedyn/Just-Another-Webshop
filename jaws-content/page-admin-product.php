<?php jaws_header();
if (!isAdmin()){
    loginPrompt("You need to be an administrator to access this page.");
}
    if ($_GET['product'] == "new" && isset($_POST['product-save'])){
        if (isset($_POST['product-id']) && preg_match("$.+$", $_POST['product-id']) &&
            isset($_POST['product-name']) && preg_match("$.+$", $_POST['product-name']) &&
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
                if (true) {
                    registerError('Product added successfully','success');
                    redirect("/admin/products/".$_POST['product-id']);
                } 
            } else {
                showError('Problem while uploading file',"danger");
            }       
        } else {
            showError('Product save failed',"danger");
            var_dump($_FILES);
            var_dump($_POST);
        }
    } else if (true){
        // Edit product     
    }

      
      ?>
      <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading "><?php if($_GET['product'] == 'new') { echo "New"; } else { echo "Edit"; }?> Product</div>
        <div class="panel-body">
          <form method="post" enctype="multipart/form-data" class="form-signin" role="form">
            Name
            <input pattern="^.+$"name="product-name" type="text" class="form-control" value="hejhe">
            description
            <textarea pattern="^.+$" name="product-description" type="text" id="mBot" rows="10" class="form-control">dsasdasdaisdaiuhdsaiuhdasiuhdsaiu aisuhdisuah iuasdhiaushd</textarea>
            <div class="row">
              <div class="col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon">Product ID</span>
                  <input pattern="^\d+$" name="product-id" type="text" class="form-control" value="342234234">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon">Price (in SEK)</span>
                  <input name="product-price" type="text" pattern="^\d+$" class="form-control" value="421">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon">Currently in stock</span>
                  <input pattern="^\d+$" name="product-stock" type="text" class="form-control" value="1">
                </div>
              </div>
              <div class="col-lg-4">
               <div class="input-group">
                <span class="input-group-addon">Weight (in gram)</span>
                <input pattern="^\d+$" name="product-weight" type="text" class="form-control" value="1400">
              </div>
            </div>
              <div class="col-lg-4">
               <div class="input-group">
                <span class="input-group-addon">Category</span>
                <select class="form-control" name="product-category">
                  <option value="false">None</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </div>
              <div class="col-lg-4">
                <span class="btn btn-block btn-default btn-file">Browse image<input name="product-image" required data-message="You need to upload an image" accept="image/jpeg" type="file">
                </span>
              </div>
          </div>
        <div class="row">
              <div class="col-lg-4">
              <button name="product-delete" class="btn btn-danger btn-block" type="submit">Delete product</button>
              </div>
              <div class="col-lg-8">
              <button name="product-save" class="btn btn-primary btn-block" type="submit">Save product</button>
              </div>
            </div>
        </form>
      </div>
    </div>
<?php jaws_footer(); ?>