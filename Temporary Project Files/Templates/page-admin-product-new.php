<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'head.php'; ?>
<title>Admin - New Product</title>
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

