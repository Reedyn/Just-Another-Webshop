<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Product Page</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="css/normalize.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="gh-buttons.css">
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script defer src="js/main.js"></script>
</head>
<body>

<section class="wrapper">
    <?php include 'header.php'; ?>
    <?php include 'navAdmin.php'; ?>
    <article class="main-content">
       <table class="table">
            <tr class="rowBold">
                <td class="col">Name</td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="row">
                <td class="col">
                    <span contenteditable="true" onclick="document.execCommand('selectAll',false,null)">
                        Name
                    </span>
                </td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="rowBold">
                <td class="col">Description</td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="row">
                <td class="colDescr">
                    <span contenteditable="true" onclick="document.execCommand('selectAll',false,null)">
                        Remove this and add whatever
                        </span>
                </td>    
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="rowBold">
                <td class="col">Product ID</td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="row">
                <td class="col">
                    <span contenteditable="true" onclick="document.execCommand('selectAll',false,null)">
                        24214
                    </span>
                </td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="rowBold">
                <td class="col">Price</td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="row">
                <td class="col">
                    <span contenteditable="true" onclick="document.execCommand('selectAll',false,null)">
                        19kr
                    </span>
                </td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="rowBold">
                <td class="col">Currently in stock</td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="row">
                <td class="col">
                    <span contenteditable="true" onclick="document.execCommand('selectAll',false,null)">
                        10st
                    </span>
                </td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="rowBold">
                <td class="col">Image</td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="row">
                <td class="col">
                    <span contenteditable="true" onclick="document.execCommand('selectAll',false,null)">
                        doksed.jpg
                    </span>
                </td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="rowBold">
                <td class="col">Weight</td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="row">
                <td class="col">
                     <span contenteditable="true" onclick="document.execCommand('selectAll',false,null)">
                        10kg
                    </span>
                </td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col">
                    <button class="button icon approve">save</button>
                </td>
            </tr>
        </table>       
        <script class="cssdeck" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
        <script src="reg.js"></script>
    </article>
    <?php include 'footer.php'; ?>
</section>
</body>
</html>

