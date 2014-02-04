<?php session_unset(); registerError("You have been logged out","success"); redirect("/"); includeHeader(); ?>
<?php includeFooter(); ?>