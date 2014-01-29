<?php jaws_header(); session_unset(); registerError("You have been logged out","success"); ;header("Location: /"); exit(); ?>
<?php jaws_footer(); ?>