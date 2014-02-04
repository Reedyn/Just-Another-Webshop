<?php includeHeader(); ?>
      <?php if (isAdmin()){ ?>
            <p>Hello Administrator!</p> 
            <?php } else {
            echo "<p>You do not have authorization to see this page!</p>";
            } ?>
<?php includeFooter(); ?>
            