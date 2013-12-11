<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-content/header.php"; include $_SERVER['DOCUMENT_ROOT']."/jaws-content/navAdmin.php";	?>

		<section class="wrapper">
			<article class="main-content">
				<?php if (isset($_SESSION['IsAdmin'])){
					require($_SERVER['DOCUMENT_ROOT'].'/jaws-includes/db.php');
					if ($_GET['product'] == "new"){
						if (isset($_POST['addProduct'])){
							if (false){
							
							} else {
								require_once($_SERVER['DOCUMENT_ROOT'].'/jaws-includes/image-resizer.php');
								// array of valid extensions
								$validExtensions = array('.jpg');
								// get extension of the uploaded file
								$fileExtension = strrchr($_FILES['product-image']['name'], ".");
								// check if file Extension is on the list of allowed ones
								if (in_array($fileExtension, $validExtensions)) {
									$manipulator = new ImageManipulator($_FILES['product-image']['tmp_name']);
									$newImage = $manipulator->resample(400, 200);
									// saving file to uploads folder
									$manipulator->save($_SERVER['DOCUMENT_ROOT'].'/img/' . $_FILES['product-image']['name']);
								} else {
									echo 'You must upload an image...';
								}
								if($db->dbAddProduct($_POST['name'],$_POST['description'],'/img/'.$_FILES['product-image']['name'],$_POST['taxanomy'],$_POST['price'],$_POST['stock'])){
									echo "Success";
								} else {
									echo "Couldn't add product.";
								}
							}	
						}
					?>
					<form enctype="multipart/form-data" action="/admin/products/new" method="post">
						<input type="text" name="name" pattern="^.+$" required placeholder="Product Name"></br>
						<input type="text" name="description" pattern="^.+$" required placeholder="Description"></br>
						<input type="text" name="price" pattern="^.+$" required placeholder="0"></br>
						<input type="text" name="stock" pattern="^.+$" required placeholder="0"></br>
						<input type="file" name="product-image" required></br>
						<select name="taxanomy" placeholder="Taxanomy">
							<option value="2">Consoles</option>
							<option value="3">Games</option>
							<option value="4">Accessories</option>
						</select></br>
						<input type="submit" name="addProduct" value="Add Product">	
					</form>
					<?php 
					} else {
						if (isset($_POST['editProduct'])){
							
							if($db->dbEditProduct($_POST['name'],$_POST['description'],'/img/'.$_FILES['product-image']['name'],$_POST['taxanomy'],$_POST['price'],$_POST['stock'])){
								echo "Success";
							} else {
								echo "Couldn't edit product.";
							}
					
						}
						$product = $db->dbGetProducts($_GET['product']);
						
							?>
							
					<form enctype="multipart/form-data" action="/admin/products/<?php $_GET['product']; ?>" method="post">
						<input type="text" name="name" value="<?php echo $product[0]['Name']; ?>" pattern="^.+$" required placeholder="Product Name"></br>
						<input type="text" name="description" value="<?php echo $product[0]['Description']; ?>" pattern="^.+$" required placeholder="Description"></br>
						<input type="text" name="price" value="<?php echo $product[0]['Price']; ?>" pattern="^[0-9]+$" required placeholder="0"></br>
						<input type="text" name="stock" value="<?php echo $product[0]['Stock']; ?>" pattern="^[0-9]+$" required placeholder="0"></br>
						<select name="taxanomy" placeholder="Taxanomy">
							<option value="2">Consoles</option>
							<option value="3">Games</option>
							<option value="4">Accessories</option>
						</select></br>
						<input type="submit" name="editProduct" value="Edit Product">
					</form>	
				<?php }
				} else {
				echo "<p>You do not have authorization to see this page!</p>";
				} ?>
			</article>
		</section><!-- .wrapper -->
<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-content/footer.php";	?>