<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-content/header.php";	include $_SERVER['DOCUMENT_ROOT']."/jaws-content/navAdmin.php";?>
		<section class="wrapper">
			<article class="main-content">
				<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-includes/functions.php"; 
					listProducts("admin", "ALL");
				?>
			</article>
		</section><!-- .wrapper -->
<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-content/footer.php";	?>