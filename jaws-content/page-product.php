<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-content/header.php";	include $_SERVER['DOCUMENT_ROOT']."/jaws-content/navUser.php";?>	
		<section class="wrapper">
			<article class="main-content">
				<?php /*include "/jaws-includes/functions.php";*/ 
				echo "<p>This is a product"; 
				if (isset($_GET['product'])){ 
					echo " with the id ".$_GET['product']; 
				}
				if (isset($_GET['category'])){
					echo " in category ".$_GET['category'];
				}
				echo ".</p>";
			
				var_dump($_GET);?>
			</article>
		</section><!-- .wrapper -->
<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-content/footer.php";	?>