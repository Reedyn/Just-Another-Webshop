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
            <a href=""><li>CONSOLES</li></a>
            <a href=""><li>GAMES</li></a>
            <a href=""><li>ACCESSORIES</li></a>
            <a href="login.php"><li>Login/Register</li></a>
        </ul>
    </nav>
    <article class="main-content">
        <div class="flat-form">
            <ul class="tabs">
                <li>
                    <a href="#login" class="active">Login</a>
                </li>
                <li>
                    <a href="#register">Register</a>
                </li>
                <li>
                    <a href="#reset">Reset Password</a>
                </li>
            </ul>
            <div id="login" class="form-action show">
                <h1>Login</h1>
              
                <form class="signForm">
                    <ul>
                        <li>
                            <input name="username" type="text" placeholder="Username" />
                        </li>
                        <li>
                            <input name="password" type="password" placeholder="Password" />
                        </li>
                        <li>
                            <input type="submit" value="Login" class="button" />
                        </li>
                    </ul>
                </form>
            </div>
            <!--/#login.form-action-->
            <div id="register" class="form-action hide">
                <h1>Register</h1>
                <p>
                    You should totally sign up for our super awesome service.
                    It's what all the cool kids are doing nowadays.
                </p>
                <form class="signForm">
                    <ul>
                        <li>
                            <input type="text" placeholder="Social Security Number" />
                        </li>
                        <li>
                            <input type="text" placeholder="Mail" />
                        </li>
                        <li>
                            <input type="text" placeholder="First Name" />
                        </li>
                        <li>
                            <input type="text" placeholder="Last Name" />
                        </li>
                        <li>
                            <input type="text" placeholder="Street Address" />
                        </li>
                        <li>
                            <input type="text" placeholder="City" />
                        </li>
                        <li>
                            <input type="text" placeholder="Phone" />
                        </li>
                        <li>
                            <input type="password" placeholder="Password" />
                        </li>
                        <li>
                            <input type="submit" value="Sign Up" class="button" />
                        </li>
                    </ul>
                </form>
            </div>
            <!--/#register.form-action-->
            
        </div>
    <script class="cssdeck" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script src="reg.js"></script>

    </article>
    <footer>
        <span class="footer">Copyright blabal</span>
</footer>
</body>
</html>
