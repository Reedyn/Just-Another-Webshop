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
                <td class="col">1</td>
                <td class="col">645</td>
                <td class="col"></td>
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
        <table class="table">
            <tr class="rowBold">
                <td class="col">Name</td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="row">
                <td class="col">David Klar</td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="rowBold">
                <td class="col">Shipping Address</td>
                <td class="col"></td>
                <td class="col">Billing Address</td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="row">
                <td class="col">Sodra Strandgatan 25A</td>
                <td class="col"></td>
                <td class="col">Parken</td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="row">
                <td class="col">553 20</td>
                <td class="col"></td>
                <td class="col">572 29</td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="row">
                <td class="col">Jonkoping</td>
                <td class="col"></td>
                <td class="col">Bandadad</td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
        </table>

        <table id="checkout" class="checkout">
            <tr class="row">
                <td class="col">Credit Card</td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="row">
                <td class="col">
                    <input type="text" value="********2392" readonly/> 
                    <input type="text" value="****" readonly/> 
                    <input type="text" value="David Klar" readonly/> 
                    <p class="expiration">month:</p>
                    01
                    <p class="expiration">year:</p>
                    12
                </td>
            </tr>
        </table>
        <div id="acceptDenyButtons">
            <button class="button icon arrowleft">back</button>
            <button class="button icon arrowright">Place order</button>
        </div>     
        <script class="cssdeck" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
        <script src="reg.js"></script>

    </article>
    <?php include 'footer.php'; ?>
</section>
</body>
</html>

