<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-content/header.php";	include $_SERVER['DOCUMENT_ROOT']."/jaws-content/navAdmin.php";?>
		<section class="wrapper">
			<article class="main-content">
				<?php
				if (isset($_SESSION['IsAdmin'])){
					include $_SERVER['DOCUMENT_ROOT']."/jaws-includes/functions.php"; 
					listUsers("admin", "ALL");
				} else {
					echo "<p>You do not have authorization to see this page!</p>";
				} ?>
			</article>
		</section><!-- .wrapper -->
<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-content/footer.php";	?>