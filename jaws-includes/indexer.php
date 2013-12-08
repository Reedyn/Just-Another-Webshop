<?php
	function indexer() {
	include "/jaws-content/header.php";
	
	if(isset($_GET['products'])){ 	// Checks if products is a set variable.
		if(isset($_GET['product'])){
			include "/jaws-content/page-product.php";
		} else {
			include "/jaws-content/page-products.php";
		}
	} else {
		include "/jaws-content/404.php";
	}
	include "/jaws-content/footer.php";
}
?>