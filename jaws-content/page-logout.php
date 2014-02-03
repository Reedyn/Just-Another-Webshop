<?php session_unset(); registerError("You have been logged out","success"); redirect("/"); jaws_header(); ?>
<?php jaws_footer(); ?>