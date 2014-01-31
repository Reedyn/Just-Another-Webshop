<?php jaws_header();

if(isset($_POST['user-login'])) {
    if(login()){
        $_SESSION['logged-in'] = true;
        if(isset($_SESSION['redirect'])) {
            header("Location: ".$_SESSION['redirect']);
            unset($_SESSION['redirect']);
            exit();
        }
        registerError('Welcome back','success');
        redirect("/");
    } else {
        registerError("The specified email and password combination didn't match",'danger');
        redirect();
    }
}
/* Server-side validation 
if success, register user and go to homepage. */

# the response from reCAPTCHA
$resp = null;
# the error code from reCAPTCHA, if any
$error = null;
require_once($_SERVER['DOCUMENT_ROOT'].'/jaws-includes/recaptchalib.php');
$publickey = "6Lcevu0SAAAAALVA9IWHanPReEOxtSDz5YiNnqkE";
$privatekey = "6Lcevu0SAAAAACPAZ5dGYqK1yvoFVPTfnpX6PKl8";

if(isset($_POST['user-register'])) {
    if (isset($_POST['user-ssn']) && preg_match("$\d{2,4}-?\d{2}-?\d{2}-?\d{4}$", $_POST['user-ssn']) &&
        isset($_POST['user-mail']) && preg_match("$[a-z0-9åäöÅÄÖ._%+-]+[a-zåäöÅÄÖ0-9]+@[a-z0-9.-]+\.[a-z]{2,4}$", $_POST['user-mail']) &&
        isset($_POST['user-password']) && preg_match("$[a-zA-ZåäöÅÄÖ0-9]{6,30}$", $_POST['user-password']) &&
        isset($_POST['user-first-name']) && preg_match("$\w+$", $_POST['user-first-name']) &&
        isset($_POST['user-last-name']) && preg_match("$\w+$", $_POST['user-last-name']) &&
        isset($_POST['user-post-address'])&&
        isset($_POST['user-street-address'])&&
        isset($_POST['user-city'])) {
        $_SESSION['form']['register'] = array(
            'user-ssn' => $_POST['user-ssn'],
            'user-mail' => $_POST['user-mail'],
            'user-first-name' => $_POST['user-first-name'],
            'user-last-name' => $_POST['user-last-name'],
            'user-phone' => $_POST['user-phone'],
            'user-street-address' => $_POST['user-street-address'],
            'user-post-address' => $_POST['user-post-address'],
            'user-city' => $_POST['user-city']);
        # was there a reCAPTCHA response?
        if (isset($_POST["recaptcha_response_field"]) && $_POST["recaptcha_response_field"] != "") {
            $resp = recaptcha_check_answer ($privatekey,
                                            $_SERVER["REMOTE_ADDR"],
                                            $_POST["recaptcha_challenge_field"],
                                            $_POST["recaptcha_response_field"]);
    
            if ($resp->is_valid) {
                if (registerUser()) { // Add user
                    registerError('Registration successful','success');
                    if(isset($_SESSION['redirect'])) {
                        header("Location: ".$_SESSION['redirect']);
                        unset($_SESSION['redirect']);
                        exit();
                    } 
                    
                    redirect("/");
                } else {
                    showError("Registration failed. User already exists", "danger");
                }
            } else {
                    $error = $resp->error;
                    showError("Incorrect captcha", "danger");
            }
        } else {
            showError("You need to fill in the captcha", "warning");
        }  
    } else {
        showError("Registration failed.", "danger");
    }
}?>

      <div class="well well-lg">
        <h2 class="form-signin-heading">Login with an existing account</h2>
        <form method="post" class="form-signin" role="form">
          <div class="row">
            <div class="col-lg-6">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope" ></span></span>
                <input required pattern="^[a-z0-9åäöÅÄÖ._%+-]+[a-zåäöÅÄÖ0-9]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="login-mail" type="email" class="form-control" placeholder="E-Mail">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock" ></span></span>
                <input required name="login-password" type="password" class="form-control" placeholder="Password">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->  
          </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-2">
              <button name="user-login"class="btn btn-primary btn-block btn-margin" type="submit">Login</button>
            </div>
          </div>
        </form>
      </div>

      <div class="well well-lg">
        <h2 class="form-signin-heading">Register a new account</h2>
        <form method="post" class="form-signin" role="form">
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                <input value="<?php fillForm("register","user-ssn"); ?>" pattern="^\d{2,4}-?\d{2}-?\d{2}-?\d{4}$" required name="user-ssn" type="text" class="form-control" placeholder="Social Security Number">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope" ></span></span>
                <input value="<?php fillForm("register","user-mail"); ?>" pattern="^[a-z0-9åäöÅÄÖ._%+-]+[a-zåäöÅÄÖ0-9]+@[a-z0-9.-]+\.[a-z]{2,4}$" required name="user-mail" type="email" class="form-control" placeholder="E-Mail">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock" ></span></span>
                <input pattern="^[a-zA-ZåäöÅÄÖ0-9]{6,30}$" data-message="Your password needs to be at least 6 characters long." required name="user-password" type="password" class="form-control" placeholder="Password">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->  
            </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input value="<?php fillForm("register","user-first-name"); ?>" pattern="^\w+$" required name="user-first-name" type="text" class="form-control" placeholder="First Name">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
          
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input value="<?php fillForm("register","user-last-name"); ?>" pattern="^\w+$" required name="user-last-name" type="text" class="form-control" placeholder="Last Name">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-earphone" ></span></span>
                <input value="<?php fillForm("register","user-phone"); ?>" pattern="^(46|\+46|0)(-?\s?[0-9]+)+$" required name="user-phone" type="tel" class="form-control" placeholder="Phone">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 --> 
            </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input value="<?php fillForm("register","user-street-address"); ?>" name="user-street-address" required type="text" class="form-control" placeholder="Street Address">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input value="<?php fillForm("register","user-post-address"); ?>" name="user-post-address" required type="text" class="form-control" placeholder="Post Address">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->  
          
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input value="<?php fillForm("register","user-city"); ?>" name="user-city" type="text" required class="form-control" placeholder="City">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
          </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-4">
                <?php
                  echo recaptcha_get_html($publickey);
                ?>
            </div>
            <div class="col-lg-8">
              <button name="user-register" class="btn btn-primary btn-block" type="submit">Register account</button>
            </div>
          </div>
        </form>
      </div>
<?php jaws_footer(); ?>