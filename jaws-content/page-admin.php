<?php jaws_header(); ?>
		    <div class="container marketing">
      <?php if (isAdmin()){ ?>
            <p>Hello Administrator!</p> 
            <?php } else {
            echo "<p>You do not have authorization to see this page!</p>";
            } ?>

      <hr class="featurette-divider">
<?php jaws_footer(); ?>
            