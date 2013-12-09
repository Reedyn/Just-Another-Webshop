		<section class="wrapper">
			<article class="main-content">
				<?php /*include "/jaws-includes/functions.php";*/ 
				if(isset($_GET['404'])){ 
					if(!($_GET['404'] == "")) {
						echo $_GET['404']; 
					}
				} else {
					echo "Page";
				}
				echo " not found."; 
				
				var_dump($_GET);?>
			</article>
		</section><!-- .wrapper -->