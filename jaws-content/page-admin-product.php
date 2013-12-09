		
		<section class="wrapper">
			<article class="main-content">
				<?php /*include "/jaws-includes/functions.php";*/
				if ($_GET['product'] == "new"){
					echo "<p>Admin page for creating a new product.</p>";
				} else {
					echo "<p>Admin page for product with id ".$_GET['product'].".</p>"; 
				}	
				var_dump($_GET);?>
			</article>
		</section><!-- .wrapper -->
