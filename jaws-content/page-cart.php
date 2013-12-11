<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-content/header.php";	include $_SERVER['DOCUMENT_ROOT']."/jaws-content/navUser.php";?>
		<section class="wrapper">
			<article class="main-content">
				<?php include_once $_SERVER['DOCUMENT_ROOT']."/jaws-includes/functions.php"; 
				
				if($_GET['cart'] == "review"){
					echo "<p>Review - Shopping Cart.</p>";
				} elseif($_GET['cart'] == "checkout") {
					echo "<p>Checkout - Shopping Cart.</p>";
				} else {
					$_SESSION['cart'] = array();
					array_push($_SESSION['cart'], array(
						"id" => "5345645438",
					));
					array_push($_SESSION['cart'], array(
						"id" => "534564543",
					));
					
					listUsers("table","12345");
				} ?>
			
			</article>
		</section><!-- .wrapper -->
<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-content/footer.php";	?>