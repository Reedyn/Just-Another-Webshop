<?php


class Index {
	protected $theme;
	public function __construct($theme = "default"){
		$this->theme = $theme;
	}
	
	public function initialize() { 		// Primary function
		if(isset($_GET['home'])){ 	// If no variable is set.
			echo "Home";
		} elseif (isset($_GET['page'])) {
			echo "Page";
		} else {
			echo "404";
		}
	}
	
	public function getTitle(){
	}
}

?>