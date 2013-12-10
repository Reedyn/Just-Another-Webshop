
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
            <a href=""><li>Login/Register</li></a>
        </ul>
    </nav>
    <article class="main-content">
<form action="login.php" method="post">
    <input type="text" name="firstName" placeholder="first name..."></br>
    <input type="text" name="lastName" placeholder="last name..."></br>
    <input type="text" name="streetAdress" placeholder="street address..."></br>
    <input type="text" name="postAddress" placeholder="post address..."></br>
    <input type="text" name="city" placeholder="city..."></br>
    <input type="text" name="phone" placeholder="phone..."></br>
    <input type="text" name="email" placeholder="email..."></br>
    <input type="password" name="password" id="password" placeholder="password..."></br>
    <select name="country" placeholder="country...">
        <option value="sweden">Sweden</option>
        <option value="norway">Norway</option>
        <option value="usa">United States of America</option>
        <option value="china">China</option>
    </select></br>
    <input type="radio" name="gender" value="male" /> Male<br />
    <input type="radio" name="gender" value="female"/> Female<br />
    <input type="checkbox" name="newsletter" placeholder="newsletter..."> Newsletter</br>
    <input type="submit">
</form>

<?php
$chars = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f');
?>



    </article>
    <footer>
        <span class="footer">Copyright blabal</span>
</section><!-- .wrapper -->
</footer>
</section><!-- .wrapper -->

</body>
</html>

