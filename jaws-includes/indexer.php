<?php
	
function indexer() { // Function for delivering pages based on GET variables.
	/* ######################################
					Admin
	*/ ######################################
	if(isset($_GET['admin'])){ // Check if user is trying to access admin
		if($_GET['admin'] == "products"){
			if(isset($_GET['product'])){ 			
				include($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin-product.php"); // Load product if user is trying to access a specific product.
			} else { 
				include($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin-products.php"); // Otherwise load product list.
			}
		} else if($_GET['admin'] == "orders"){
			if(isset($_GET['order'])){				
				include($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin-order.php"); // Load order if user is trying to access a specific order.	
			} else {
				include($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin-orders.php"); // Otherwise load list of orders.
			}
		} else if($_GET['admin'] == "users"){
			if(isset($_GET['user'])){ 				
				include($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin-user.php"); // Load product if user is trying to access a specific product.	
			} else { 
				include($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin-users.php"); // Otherwise load product list.
			}
		} else if($_GET['admin'] == "taxanomies"){
			if(isset($_GET['taxanomy'])){ 				
				include($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin-taxanomy.php"); // Load product if user is trying to access a specific product.	
			} else { 
				include($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin-taxanomies.php"); // Otherwise load product list.
			}
		} else if($_GET['admin'] == ""){
			include($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin.php"); // If sub-page isn't defined load admin page.
		} else {
			include($_SERVER['DOCUMENT_ROOT']."/jaws-content/404.php"); // Otherwise load 404.
		}
	/* ######################################
					Settings
	*/ ######################################
	} else if(isset($_GET['settings'])){ // Check if user is trying to access admin
		if($_GET['settings'] == "orders"){
			if(isset($_GET['order'])){ 			
				include($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-settings-order.php"); // Load product if user is trying to access a specific product.
			} else { 
				include($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-settings-orders.php"); // Otherwise load product list.
			}
		} else if($_GET['settings'] == "user"){
			include($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-settings-user.php"); // Load order if user is trying to access a specific order.	
		} else if($_GET['settings'] == ""){
			include($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-settings.php"); // If sub-page isn't defined load admin page.
		} else {
			include($_SERVER['DOCUMENT_ROOT']."/jaws-content/404.php"); // Otherwise load 404.
		}
	
	/* ######################################
					Products
	*/ ######################################	
	} else if(isset($_GET['products'])){ 
		if(isset($_GET['product'])){
			include($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-product.php"); // If user is trying to access a specific product load product.
		} else {
			include($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-products.php"); // Otherwise load list of products.
		}
	
	
	/* ######################################
					Cart
	*/ ######################################	
	} else if(isset($_GET['cart'])){
			include($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-cart.php");

	/* ######################################
					Home
	*/ ######################################	
	} else if(isset($_GET['home'])) {
		include($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-home.php");
	
	/* ######################################
					Register
	*/ ######################################	
	} else if(isset($_GET['login'])) {
		include($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-login.php");
		
	/* ######################################
					  404
	*/ ######################################	
	} else if(isset($_GET['404'])) {
		include($_SERVER['DOCUMENT_ROOT']."/jaws-content/404.php");
	} else {
		include($_SERVER['DOCUMENT_ROOT']."/jaws-content/404.php");
	}
}

?>