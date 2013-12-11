<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-content/header.php";	include $_SERVER['DOCUMENT_ROOT']."/jaws-content/navUser.php";?>
		<section class="wrapper">
			<article class="main-content">
				<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-includes/functions.php"; 
				listOrders("user", $_SESSION['SSNr']);
				?>
			</article>
		</section><!-- .wrapper -->
<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-content/footer.php";	?>