<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'head.php'; ?>
<title>Admin - New Taxonomy</title>
</head>
<body>

<section class="wrapper">
    <?php include 'header.php'; ?>
    <?php include 'navAdmin.php'; ?>
    <article class="main-content">  
        <table class="table">
            <tr class="rowBold">
                <td class="col">Parent</td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="row">
                <td class="col">
                    <span contenteditable="true" onclick="document.execCommand('selectAll',false,null)">
                        ...
                    </span>
                </td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="rowBold">
                <td class="col">Name</td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="row">
                <td class="colDescr">
                    <span contenteditable="true" onclick="document.execCommand('selectAll',false,null)">
                        ...
                        </span>
                </td>    
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="rowBold">
                <td class="col">ID</td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"></td>
            </tr>
            <tr class="row">
                <td class="col">
                    <span contenteditable="true" onclick="document.execCommand('selectAll',false,null)">
                        ...
                    </span>
                </td>
                <td class="col"></td>
                <td class="col"></td>
                <td class="col"><button class="button icon approve">save</button></td>
            </tr>
        </table>      
        <script class="cssdeck" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
        <script src="reg.js"></script>
    </article>
    <?php include 'footer.php'; ?>
</section>
</body>
</html>

