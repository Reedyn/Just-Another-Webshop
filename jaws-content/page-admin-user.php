<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-content/header.php";	include $_SERVER['DOCUMENT_ROOT']."/jaws-content/navAdmin.php";?>	
		<section class="wrapper">
			<article class="main-content">
				<?php
				if (isset($_SESSION['IsAdmin'])){
					if ($_GET['user'] == "new"){
						echo "<p>Admin page for creating a new user.</p>";
					} else {
						echo "<p>Admin page for user with id ".$_GET['user'].".</p>"; 
					}	
					var_dump($_GET);
				} else {
					echo "<p>You do not have authorization to see this page!</p>";
				} ?>
			</article>
		</section><!-- .wrapper -->
<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-content/footer.php";	?>