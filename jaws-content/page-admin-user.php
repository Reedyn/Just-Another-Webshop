<?php 
/* Server-side validation 
if success, register user and go to homepage. */
if(isset($_POST['user-submit'])) {
    if($_POST['user-submit'] == 'new') {
        if (isset($_POST['user-ssn']) && preg_match("$\d{2,4}-?\d{2}-?\d{2}-?\d{4}$", $_POST['user-ssn']) &&
            isset($_POST['user-mail']) && preg_match("$[a-z0-9åäöÅÄÖ._%+-]+[a-zåäöÅÄÖ0-9]+@[a-z0-9.-]+\.[a-z]{2,4}$", $_POST['user-mail']) &&
            isset($_POST['user-first-name']) && preg_match("$.+$", $_POST['user-first-name']) &&
            isset($_POST['user-last-name']) && preg_match("$.+$", $_POST['user-last-name']) &&
            isset($_POST['user-phone']) && preg_match("$(46|\+46|0)(-?\s?[0-9]+)+$", $_POST['user-phone']) &&
            isset($_POST['user-post-address']) && isset($_POST['user-street-address']) && isset($_POST['user-city'])) {
            $password = generatePassword(20);
            if($_POST['user-admin'] == "false"){
                $_POST['user-admin'] = 0;
            } elseif ($_POST['user-admin'] == "true"){
                $_POST['user-admin'] = 1;
            }
            $remove = array("-",);
            $_POST['user-ssn'] = str_replace($remove, "", $_POST['user-ssn']);
            // Add user to database if successful do
            if ($db->dbAddUser($_POST['user-ssn'],
                    $_POST['user-mail'],
                    $password,
                    $_POST['user-first-name'],
                    $_POST['user-last-name'],
                    $_POST['user-street-address'],
                    $_POST['user-post-address'],
                    $_POST['user-city'],
                    $_POST['user-phone'],
                    $_POST['user-admin'])) {
                    
                // Send registration email to user
                $message = '<html>
                                <head>
                                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                    <title>[Hockey Gear] Account created</title>
                                <head>
                                <body>
                                    <p>Your account has been created</p>
                                    <p>Your password is: '.$password.'</p>
                                    <p>You can login at http://hockeygear.lindqvist.io/login/</p>
                                </body>
                            </html>';
                $message = wordwrap($message, 70, "\r\n"); 
                $to      = $_POST['user-first-name'].' '.$_POST['user-last-name'].' <'.$_POST['user-mail'].'>';
                $subject = '[Hockey Gear] Account created';
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: Hockey Gear <noreply@hockeygear.com>' . "\r\n";
                $headers .= 'Reply-To: webmaster@hockeygear.com' . "\r\n";
                $headers .= 'X-Mailer: PHP/' . phpversion();
                mail($to, $subject, $message, $headers);
                    
                registerError($_POST['user-first-name'].' '.$_POST['user-last-name'].' added','success');
                redirect("/admin/users/".$_POST['user-ssn']);
            } else {
                registerError("Adding user failed", "danger");
                redirect();
            }
        } else {
            registerError("Adding user failed", "danger");
            redirect();
        }
    } else {
        if (isset($_POST['user-first-name']) && preg_match("$[A-ZÅÄÖa-zåäö]+$", $_POST['user-first-name']) &&
            isset($_POST['user-last-name']) && preg_match("$[A-ZÅÄÖa-zåäö]+$", $_POST['user-last-name']) &&
            isset($_POST['user-phone']) && preg_match("$(46|\+46|0)(-?\s?[0-9]+)+$", $_POST['user-phone'])) {
            if($_POST['user-admin'] == "false"){
                $_POST['user-admin'] = false;
            } elseif ($_POST['user-admin'] == "true"){
                $_POST['user-admin'] = true;
            }
            if ($db->dbEditUser($_POST['user-ssn'],
                    "FirstName",$_POST['user-first-name'],
                    "LastName",$_POST['user-last-name'],
                    "Telephone",$_POST['user-phone'],
                    "StreetAddress",$_POST['user-street-address'],
                    "PostAddress",$_POST['user-post-address'],
                    "City",$_POST['user-city'],
                    "IsAdmin",$_POST['user-admin'])) {
                registerError($_POST['user-first-name'].' '.$_POST['user-last-name'].' edited','success');
                redirect();
            } else {
                registerError("User couldn't be saved to the database", "danger");
                redirect();
            }
        } else {
            registerError("Validation of user failed", "danger");
            redirect();
        }
    }
    
}
if (isset($_POST['reset-password']) && isset($_POST['user-mail'])) {
    forgotPassword($_POST['user-mail']);
}

if(isset($_POST['user-delete'])) {
    if($db->dbDeleteUser($_POST['user-delete'])){
        registerError($_POST['user-first-name'].' '.$_POST['user-last-name'].' has been deleted','success');
        redirect('/admin/users/');
    } else {
        registerError($_POST['user-first-name'].' '.$_POST['user-last-name']." couldn't be deleted. There is probably orders for this user still existing",'danger');
        redirect();
    }
}
jaws_header(); 
?>

<?php if(isset($_GET['user']) && $_GET['user'] == 'new') { ?>

      <div class="panel panel-primary">
          <div class="panel-heading">Add User</div>
          <div class="panel-body">
        <form method="post" class="form-signin" role="form">
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                <input pattern="^\d{2,4}-?\d{2}-?\d{2}-?\d{4}$" required name="user-ssn" type="text" class="form-control" placeholder="Social Security Number">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope" ></span></span>
                <input pattern="^[a-z0-9åäöÅÄÖ._%+-]+[a-zåäöÅÄÖ0-9]+@[a-z0-9.-]+\.[a-z]{2,4}$" required name="user-mail" type="email" class="form-control" placeholder="E-Mail">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock" ></span></span>
                <input title="Password is automatically generated." pattern="^[a-zA-ZåäöÅÄÖ0-9]{6,30}$" readonly required name="user-password" type="password" class="form-control" placeholder="Password">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->  
            </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input pattern="^[A-ZÅÄÖa-zåäö]+$" required name="user-first-name" type="text" class="form-control" placeholder="First Name">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
          
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input pattern="^[A-ZÅÄÖa-zåäö]+$" required name="user-last-name" type="text" class="form-control" placeholder="Last Name">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-earphone" ></span></span>
                <input pattern="^(46|\+46|0)(-?\s?[0-9]+)+$" required name="user-phone" type="tel" class="form-control" placeholder="Phone">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 --> 
            </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="user-street-address" required type="text" class="form-control" placeholder="Street Address">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="user-post-address" required type="text" class="form-control" placeholder="Post Address">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->  
          
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="user-city" required type="text" class="form-control" placeholder="City">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
          </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-2">
                 <a href="/admin/users/" class="btn btn-default btn-block">Back</a>
            </div>
            <div class="col-lg-2">
            </div>
            <div class="col-lg-4">
              <div class="input-group">
                  <span required class="input-group-addon">Access level</span>
                  <select class="form-control" name="user-admin">
                      <option selected value="false">User</option>
                      <option value="true">Admin</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
              <button name="user-submit" class="btn btn-primary btn-block" type="submit" value="new">Add User</button>
            </div>
          </div>
        </form>
      </div>
      </div>
<?php } else {
    listAdminSingleUser($_GET['user']);
    ?>
<?php } jaws_footer(); ?>