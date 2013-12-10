		
		<section class="wrapper">
			<article class="main-content">
				<?php /*include "/jaws-includes/functions.php";*/
				if ($_GET['product'] == "new"){
					var_dump($_POST);
					var_dump($_FILES);
					if (isset($_POST['addProduct'])){
							require_once($_SERVER['DOCUMENT_ROOT'].'/jaws-includes/image-resizer.php');
							// array of valid extensions
							$validExtensions = array('.jpg');
							// get extension of the uploaded file
							$fileExtension = strrchr($_FILES['product-image']['name'], ".");
							// check if file Extension is on the list of allowed ones
							if (in_array($fileExtension, $validExtensions)) {
								$newNamePrefix = $_POST['product-id'];
								$manipulator = new ImageManipulator($_FILES['product-image']['tmp_name']);
								$newImage = $manipulator->resample(200, 100);
								// saving file to uploads folder
								$manipulator->save($_SERVER['DOCUMENT_ROOT'].'/img/' . $newNamePrefix . '.jpg');
								echo '<img src="/img/'.$_POST['product-id'].'.jpg">';
							} else {
								echo 'You must upload an image...';
							}
						}
				?>
				<form enctype="multipart/form-data" action="/admin/products/new" method="post">
					<input type="text" name="product-id" pattern="^.+$" required placeholder="Product ID"></br>
					<input type="text" name="product-name" pattern="^.+$" required placeholder="Product Name"></br>
					<input type="text" name="product-description" pattern="^.+$" required placeholder="Description"></br>
					<input type="file" name="product-image" required></br>
					<input type="submit" name="addProduct" value="Add Product">	
				</form>
				<?php 
				} else {
					echo "<p>Admin page for product with id ".$_GET['product'].".</p>"; 
				}	
				var_dump($_GET);?>
			</article>
		</section><!-- .wrapper -->
