
		<section class="wrapper">
			<article class="main-content">
				<?php /*include "/jaws-includes/functions.php";*/ echo "This is a list of all products"; if (isset($_GET['category'])){ echo " in category ".$_GET['category']; }
				echo "<p>";
				var_dump($_GET);
				echo "</p>"; ?>
			</article>
		</section><!-- .wrapper -->
		