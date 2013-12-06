<?php


class Index {
	protected $theme;
	public function __construct($theme = "default"){
		$this->theme = $theme;
	}
	
	public function initialize() { 		// Primary function
		if(isset($_GET['products'])){ 	// If no variable is set.
			echo "Products";
		} elseif (isset($_GET['category'])) {
			echo "Category: ".$_GET['category'];
		} else {
			echo "404";
		}
	}
	
	public function getTitle(){
	}
}

?>