<?php

function router() { // Function for delivering pages based on GET variables and building website title.
	require_once($_SERVER['DOCUMENT_ROOT']."/jaws-includes/functions.php");
	if(!isset($_SESSION['currency']) || (!isset($_SESSION['currency']['multiplier']) && $_SESSION['currency']['multiplier'] == null)){ 
        setCurrency(1,"Euro","€", "prefix",1); //Set to the default currency;
    };
    
	if(isset($_GET['logout'])){ // Check if user is trying to logout
	    require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-logout.php");
	/* ######################################
					Admin
	*/ ######################################
    } else if(isset($_GET['admin'])){ // Check if user is trying to access admin
        if (!isAdmin()){
            loginPrompt("You need to be an administrator to access this page.");
        }
		if($_GET['admin'] == "products"){
			if(isset($_GET['product'])){ 			
				require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin-product.php"); // Load product if user is trying to access a specific product.
			} else { 
				require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin-products.php"); // Otherwise load product list.
			}
        } else if($_GET['admin'] == "shipping"){			
            if(isset($_GET['package'])){ 			
				require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin-shipping-weight.php"); // Load product if user is trying to access a specific product.
			} else { 
				require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin-shipping.php"); // Otherwise load product list.
			}
		} else if($_GET['admin'] == "orders"){
			if(isset($_GET['order'])){				
				require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin-order.php"); // Load order if user is trying to access a specific order.	
			} else {
				require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin-orders.php"); // Otherwise load list of orders.
			}
		} else if($_GET['admin'] == "users"){
			if(isset($_GET['user'])){ 				
				require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin-user.php"); // Load product if user is trying to access a specific product.	
			} else { 
				require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin-users.php"); // Otherwise load product list.
			}
		} else if($_GET['admin'] == "categories"){
			if(isset($_GET['category'])){ 				
				require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin-taxanomy.php"); // Load product if user is trying to access a specific product.	
			} else { 
				require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin-taxanomies.php"); // Otherwise load product list.
			}
		} else if($_GET['admin'] == "currencies"){
			if(isset($_GET['currency'])){ 				
				require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin-currency.php"); // Load product if user is trying to access a specific product.	
			} else { 
				require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin-currencies.php"); // Otherwise load product list.
			}
		} else if($_GET['admin'] == ""){
			require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-admin.php"); // If sub-page isn't defined load admin page.
		} else {
			require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/404.php"); // Otherwise load 404.
		}
	/* ######################################
					Settings
	*/ ######################################
	} else if(isset($_GET['settings'])){ // Check if user is trying to access admin
		if (!isLoggedIn()){
            loginPrompt("You need to be logged in to access this page.");
        }
		if($_GET['settings'] == "orders"){
			if(isset($_GET['order'])){ 			
				require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-settings-order.php"); // Load product if user is trying to access a specific product.
			} else { 
				require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-settings-orders.php"); // Otherwise load product list.
			}
		} else if($_GET['settings'] == "user"){
			require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-settings-user.php"); // Load order if user is trying to access a specific order.	
		} else if($_GET['settings'] == ""){
			require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-settings.php"); // If sub-page isn't defined load admin page.
		} else {
			require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/404.php"); // Otherwise load 404.
		}
	
	/* ######################################
					Products
	*/ ######################################	
	} else if(isset($_GET['products'])){ 
		if(isset($_GET['product'])){
			require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-product.php"); // If user is trying to access a specific product load product.
		} else {
			if (isset($_GET['category'])) {
			    require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-products.php"); // Otherwise load list of products.
			} else {
			    $_GET['category'] = 1;
			    require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-products.php"); // Otherwise load list of products.
			}
		}
	
	
	/* ######################################
					Cart
	*/ ######################################	
	} else if(isset($_GET['cart'])){
			if($_GET['cart'] == 'review'){
			    require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-cart-review.php");
			}else {
			    require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-cart.php");
			}
			

	/* ######################################
					Home
	*/ ######################################	
	} else if(isset($_GET['home'])) {
		  require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-home.php");
		
	/* ######################################
					Search
	*/ ######################################	
	} else if(isset($_GET['search'])) {
		  require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-search.php");
		
	
	/* ######################################
					Login
	*/ ######################################	
	} else if(isset($_GET['login'])) {
		require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/page-login.php");
    
    /* ######################################
					Reset Password
	*/ ######################################	
	} else if(isset($_GET['reset-password'])) {
		require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/reset-password.php");
		
	/* ######################################
					  404
	*/ ######################################	
	} else if(isset($_GET['404'])) {
		require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/404.php");
	} else {
		require_once($_SERVER['DOCUMENT_ROOT']."/jaws-content/404.php");
	}
}

?>