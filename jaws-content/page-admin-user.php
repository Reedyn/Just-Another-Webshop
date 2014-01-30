<?php jaws_header(); 

/* Server-side validation 
if success, register user and go to homepage. */
if(isset($_POST['user-submit'])) {
    if($_POST['user-submit'] == 'new') {
        if (isset($_POST['user-ssn']) && preg_match("$\d{2,4}-?\d{2}-?\d{2}-?\d{4}$", $_POST['user-ssn']) &&
            isset($_POST['user-mail']) && preg_match("$[a-z0-9åäöÅÄÖ._%+-]+[a-zåäöÅÄÖ0-9]+@[a-z0-9.-]+\.[a-z]{2,4}$", $_POST['user-mail']) &&
            isset($_POST['user-password']) && preg_match("$[a-zA-ZåäöÅÄÖ0-9]{6,30}$", $_POST['user-password']) &&
            isset($_POST['user-first-name']) && preg_match("$\w+$", $_POST['user-first-name']) &&
            isset($_POST['user-last-name']) && preg_match("$\w+$", $_POST['user-last-name']) &&
            isset($_POST['user-phone']) && preg_match("$(46|\+46|0)(-?\s?[0-9]+)+$", $_POST['user-phone'])) {
            // Add user to database if successful do
            if (true) {
                registerError($_POST['user-first-name'].' '.$_POST['user-last-name'].' added','success');
                header('Location: '.$_SERVER['REQUEST_URI']);
                exit(); 
            } else {
                showError("Adding user failed", "danger");
            }
        } else {
            showError("Adding user failed", "danger");
        }
    } else {
        if (isset($_POST['user-first-name']) && preg_match("$\w+$", $_POST['user-first-name']) &&
            isset($_POST['user-last-name']) && preg_match("$\w+$", $_POST['user-last-name']) &&
            isset($_POST['user-phone']) && preg_match("$(46|\+46|0)(-?\s?[0-9]+)+$", $_POST['user-phone'])) {
            // Add user to database if successful do
            if (true) {
                registerError($_POST['user-first-name'].' '.$_POST['user-last-name'].' edited','success');
                //header('Location: '.$_SERVER['REQUEST_URI']);
                //exit(); 
            } else {
                showError("Edit failed!!.", "danger");
            }
        } else {
            showError("Edit failed.", "danger");
        }
    }
    
}
if (isset($_POST['reset-password']) && isset($_POST['user-mail'])) {  
    $message = 'Passwords is reset</br>Your new password is: '.generatePassword();
    $message = wordwrap($message, 70, "\r\n"); 
    $to      = $_POST['user-first-name'].' '.$_POST['user-last-name'].' <'.$_POST['user-mail'].'>';
    $subject = '[Hockey Gear] Password reset';
    $headers = 'From: Hockey Gear <noreply@hockeygear.com>' . "\r\n" .
    'Reply-To: webmaster@hockeygear.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers);
    registerError($_POST['user-first-name'].' '.$_POST['user-last-name'].'´s password has been reset','success');
    header('Location: '.$_SERVER['REQUEST_URI']);
    exit();
}

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
                <input pattern="^\w+$" required name="user-first-name" type="text" class="form-control" placeholder="First Name">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
          
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input pattern="^\w+$" required name="user-last-name" type="text" class="form-control" placeholder="Last Name">
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
<?php } else { ?>
     <div class="panel panel-primary">
      <div class="panel-heading">Edit User</div>
      <div class="panel-body">
        <form method="post" class="form-signin" role="form">
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                <input readonly name="user-ssn" type="text" value="910201-1914" class="form-control" placeholder="Social Security Number">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope" ></span></span>
                <input readonly name="user-mail" type="email" value="gustav@glindqvist.se" class="form-control" placeholder="E-Mail">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock" ></span></span>
                <input readonly name="user-password" type="password" value="justanotherwebshop" class="form-control" placeholder="Password">
                <span class="input-group-btn">
                    <button class="btn btn-default" name="reset-password" type="submit">Reset</button>
                </span>
            </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->  
            </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input pattern="^\w+$" required name="user-first-name" type="text" class="form-control" value="Gustav" placeholder="First Name">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input pattern="^\w+$" required name="user-last-name" type="text" class="form-control" value="Lindqvist" placeholder="Last Name">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-earphone" ></span></span>
                <input pattern="^(46|\+46|0)(-?\s?[0-9]+)+$" name="user-phone" type="tel" class="form-control" value="+46761479126" placeholder="Phone">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 --> 
            </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="user-street-address" type="text" class="form-control" value="Hermansvägen 104" placeholder="Street Address">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="user-post-address" type="text" class="form-control" value="55453" placeholder="Post Address">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->  
          
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="user-city" type="text" class="form-control" value="Jönköping" placeholder="City">
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
                      <option selected value=false>User</option>
                      <option value=true>Administrator</option>
                    </select>
                </div>
            </div>            
            <div class="col-lg-2">
              <button name="user-delete" class="btn btn-danger btn-block" value="edit" type="submit">Delete User</button>
            </div>
            <div class="col-lg-2">
              <button name="user-submit" class="btn btn-primary btn-block" value="edit" type="submit">Save changes</button>
            </div>
          </div>
        </form>
      </div>
      </div>
<?php } jaws_footer(); ?>