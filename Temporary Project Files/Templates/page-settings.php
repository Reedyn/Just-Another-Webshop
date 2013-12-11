<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'head.php'; ?>
<title>Settings</title>
</head>
<body>

<section class="wrapper">
    <?php include 'header.php'; ?>
    <?php include 'navUser.php'; ?>
    <article class="main-content">
        <div class="flat-form">
            <ul class="tabs">
                <li>
                    <a href="#settings" class="active">Settings</a>
                </li>
                <li>
                    <a href="#orders">Your orders</a>
                </li>
                <li>
                    <a href="#savedCharts">Your saved charts</a>
                </li>
            </ul>
            <div id="settings" class="form-action show">
                <h1>Settings</h1>
                <form class="settings">
                    <ul>
                        <li>name</br></li>
                        <li>street address</br></li>
                        <li>mail</br></li>
                        <li>phone</br></li>
                            <input type="submit" value="Change" class="standardButton" />
                        </li>
                    </ul>
                </form>
            </div>
            <!--/#login.form-action-->
            <div id="orders" class="form-action hide">
                <h1>Orders</h1>
                <table class="table">
                        <thead>
                        <tr class="rowBold">
                            <th class="col">Order ID</th>
                            <th class="col">Date</th>
                            <th class="col">Total value</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="row">
                            <td class="col">A</td>
                            <td class="col">5</td>
                            <td class="col">Line 3</td>
                        </tr>
                        <tr class="row">
                            <td class="col">B</td>
                            <td class="col">1</td>
                            <td class="col">Line 5</td>
                        </tr>
                        <tr class="row">
                            <td class="col">C</td>
                            <td class="col">3</td>
                            <td class="col">Line 5</td>
                        </tr>
                        <tr class="row">
                            <td class="col">D</td>
                            <td class="col">Line 4</td>
                            <td class="col">Line 5</td>
                        </tr>
                        <tr class="row">
                            <td class="col">F</td>
                            <td class="col">2</td>
                            <td class="col">Line 3</td>
                        </tr>
                        <tr class="row">
                            <td class="col">G</td>
                            <td class="col">7</td>
                            <td class="col">Line 5</td>
                        </tr>
                        <tr class="row">
                            <td class="col">Line 1</td>
                            <td class="col">18</td>
                            <td class="col">Line 3</td>
                        </tr>
                        <tr class="row">
                            <td class="col">Line 1</td>
                            <td class="col">123</td>
                            <td class="col">Line 5</td>
                        </tr>
                        <tr class="row">
                            <td class="col">Line 1</td>
                            <td class="col">7</td>
                            <td class="col">Line 3</td>
                        </tr>
                        <tr class="row">
                            <td class="col">Line 1</td>
                            <td class="col">12</td>
                            <td class="col">Line 5</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!--/#register.form-action-->
                <div id="savedCharts" class="form-action hide">
                    <h1>Charts</h1>
                </div>
        </div>
    <script class="cssdeck" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script src="reg.js"></script>
    </article>
    <?php include 'footer.php'; ?>
</section>
</body>
</html>

