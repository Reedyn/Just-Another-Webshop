		
		<section class="wrapper">
			<article class="main-content">
				<?php /*include "/jaws-includes/functions.php";*/
				if ($_GET['taxanomy'] == "new"){
					echo "<p>Admin page for creating a new taxanomy.</p>";
				} else {
					echo "<p>Admin page for taxanomy with id ".$_GET['taxanomy'].".</p>"; 
				}	
				var_dump($_GET);?>
			</article>
		</section><!-- .wrapper -->
