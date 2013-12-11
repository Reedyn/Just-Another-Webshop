<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'head.php'; ?>
<title>Settings User</title>
</head>
<body>

<section class="wrapper">
    <?php include 'header.php'; ?>
    <?php include 'navUser.php'; ?>
    <article class="main-content">
        <div class="flat-form">
            <div class="changeProfile">
                <h1>Profile</h1>
                <form class="signForm">
                    <ul>
                        <li>
                            <input type="text" readonly placeholder="Social Security Number" />
                        </li>
                        <li>
                            <input type="text" placeholder="First Name" />
                        </li>
                        <li>
                            <input type="text" placeholder="Last Name" />
                        </li>
                        <li>
                            <input type="text" placeholder="Mail" />
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
                            <input type="password" placeholder="Old password" />
                        </li>
                        <li>
                            <input type="password" placeholder="Password" />
                        </li>
                        <li>
                            <input type="password" placeholder="Repeat password" />
                        </li>
                        <li>
                            <input type="submit" value="Change profile" class="standardButton" />
                        </li>
                    </ul>
                </form>
            </div>
            <!--/#register.form-action-->
        </div>
    <script class="cssdeck" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script src="reg.js"></script>
    </article>
<?php include 'footer.php'; ?>
</section>
</body>
</html>

