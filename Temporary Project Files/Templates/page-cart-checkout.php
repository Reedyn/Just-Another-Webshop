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
                    <input type="text" placeholder="Card number" /> 
                    <input type="text" placeholder="cvc" /> 
                    <input type="text" placeholder="Full name" /> 
                    <p class="expiration">month:</p>
                    <select>
                        <option>01</option>
                        <option>02</option>
                        <option>03</option>
                        <option>04</option>
                        <option>05</option>
                        <option>06</option>
                    </select>
                    <p class="expiration">year:</p>
                    <select>
                        <option>13</option>
                        <option>14</option>
                        <option>15</option>
                        <option>16</option>
                        <option>17</option>
                    </select>          
                </td>
              
            </tr>
        </table>
        <div id="acceptDenyButtons">
            <button class="button icon arrowleft">back</button>
            <button class="button icon arrowright">forward</button>
        </div>    
        <script class="cssdeck" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
        <script src="reg.js"></script>
    </article>
    <?php include 'footer.php'; ?>
</section>
</body>
</html>

