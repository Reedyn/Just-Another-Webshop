<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/jaws-content/themes/default/img/favicon.ico">

  <title>Hockey Gear</title>

  <!-- Bootstrap core CSS -->
  <link href="/jaws-content/themes/default/css/bootstrap.css" rel="stylesheet">

  <!-- Just for debugging purposes. Don't actually copy this line! -->
  <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
      <![endif]-->

      <!-- Custom styles for this template -->
    <link href="/jaws-content/themes/default/css/carousel.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/jaws-content/themes/default/js/validatr.min.js"></script>
    <script type="text/javascript">
        $(function ($) {
            $('form').validatr(); 
        });
    </script>
    </head>
    <?php jaws_navigation(); ?>
    <div class="container marketing">
    
    <?php
    include_once "/jaws-includes/functions.php";
    if(isset($_SESSION['error'])) {
        showError($_SESSION['error']['message'], $_SESSION['error']['type']);
        unset($_SESSION['error']);
    }
    if (isset($_POST['add-to-cart'])){
        addToCart($_POST['add-to-cart']);
        header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        exit; 
    }
    ?>