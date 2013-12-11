<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Product Page</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" type="text/css" href="gh-buttons.css">
    <link rel="stylesheet" href="css/normalize.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script defer src="js/main.js"></script>
</head>
<body>

<section class="wrapper">
    <?php include 'header.php'; ?>
    <?php include 'navUser.php'; ?>
    <article class="main-content">   
        <table class="table">
            <tr class="rowBold">
                <td class="col">Product</td>
                <td class="col">Weight</td>
                <td class="col">Price</td>
                <td class="col">Amount</td>
                <td class="col">Total</td>
                <td class="col"></td>
            </tr>
            <tr class="row">
                <td class="col">Wacom INto</td>
                <td class="col">10 kg</td>
                <td class="col">645 kr</td>
                <td class="col"><input type="text" value="1" /></td>
                <td class="col">645</td>
                <td class="col"><a href="#" class="button icon remove">Remove</a></td>
            </tr>
            <tr class="row">
                <td class="col"></td>
                <td class="col"></td>
                <td class="col">Shipping costs</td>
                <td class="col"></td>
                <td class="col">49</td>
                <td class="col"></td>
            </tr>
            <tr class="row">
                <td class="col"></td>
                <td class="col"></td>
                <td class="col">Total, incl. Shipping</td>
                <td class="col"></td>
                <td class="col">749</td>
                <td class="col"></td>
            </tr>
        </table>         
        <script class="cssdeck" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
        <script src="reg.js"></script>
    </article>
    <?php include 'footer.php'; ?>
</section>
</body>
</html>

