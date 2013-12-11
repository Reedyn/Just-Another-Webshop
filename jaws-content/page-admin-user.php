<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-content/header.php";	?>		
		<section class="wrapper">
			<article class="main-content">
				<?php /*include "/jaws-includes/functions.php";*/ 
				if ($_GET['user'] == "new"){
					echo "<p>Admin page for creating a new user.</p>";
				} else {
					echo "<p>Admin page for user with id ".$_GET['user'].".</p>"; 
				}	
				var_dump($_GET);?>
			</article>
		</section><!-- .wrapper -->
<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-content/footer.php";	?>