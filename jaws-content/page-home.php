<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-content/header.php";	include $_SERVER['DOCUMENT_ROOT']."/jaws-content/navUser.php"; if(isset($_GET['logout'])){ session_unset(); }?>		
		<section class="wrapper">
			<article class="main-content">
				<?php /*include "/jaws-includes/functions.php";*/ 
				echo "<p>There's no place like ::1</p>";
			
				var_dump($_SESSION);?>
			</article>
		</section><!-- .wrapper -->
<?php include $_SERVER['DOCUMENT_ROOT']."/jaws-content/footer.php";	?>