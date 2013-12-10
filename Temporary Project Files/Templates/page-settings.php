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

    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script defer src="js/main.js"></script>

</head>
<body>

<section class="wrapper">
    <header class="site-head">
        <section class="wrapper">
            <img src="img/logotype.png">
        </section><!-- .wrapper -->
    </header>
    <nav class="site-nav">
            <ul>
                    <li>
                        <a href="#">CONSOLES</a>
                        <ul>
                            <a href=""><li>XBOX</li></a>
                            <a href=""><li>ATARI</li></a>
                            <a href=""><li>PLAYSTATION</li></a>
                            <a href=""><li>NINTENDO</li></a>
                            <a href=""><li>OTHER</li></a>
                        </ul>
                    </li>
                
                <a href=""><li>GAMES</li></a>
                <a href=""><li>ACCESSORIES</li></a>
                <a href="login.php"><li>Login/Register</li></a>
            </ul>
        </nav>
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
                        name </br>
                        street address </br>
                        address </br>
                         </br>
                        mail </br>
                        phone </br>
                        <li>
                            <input type="submit" value="Change" class="button" />
                        </li>
                    </ul>
                </form>
            </div>
            <!--/#login.form-action-->
            <div id="orders" class="form-action hide">
                <h1>Orders</h1>
                <table id="table" class="tablesorter">
                        <thead>
                        <tr class="row">
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
    <footer>
        <span class="footer">Copyright blabal</span>
</footer>
</body>
</html>

