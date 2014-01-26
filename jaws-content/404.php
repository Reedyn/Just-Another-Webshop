<?php jaws_header(); ?>
		<section class="wrapper">
			<article class="main-content">
				<?php
				if(isset($_GET['404'])){ 
					if(!($_GET['404'] == "")) {
						echo $_GET['404']; 
					}
				} else {
					echo "Page";
				}
				echo " not found."; ?>
			</article>
		</section><!-- .wrapper -->
<?php jaws_footer(); ?>