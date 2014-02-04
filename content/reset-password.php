<?php

if(isset($_POST['save-password']) && isset($_GET['key']) && $_GET['key'] != ""){
    savePassword($_GET['key'],$_POST['password']);
}

if(isset($_POST['reset-password'])){ // When user presses reset password
    forgotPassword($_POST['reset-mail']);
}

includeHeader(); ?>

<?php
if (isset($_GET['key']) && $_GET['key'] != ""){?>
    <div class="well well-lg">
        <h2 class="form-signin-heading">Save your new password</h2>
        <form method="post" class="form-signin" role="form">
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock" ></span></span>
                <input id="login-mail" required name="password" type="password" class="form-control" placeholder="Password">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 --> 
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock" ></span></span>
                <input id="login-mail" required name="repeat-password" type="password" class="form-control" placeholder="Password">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <button name="save-password"class="btn btn-primary btn-block" type="submit">Save Password</button>
            </div>
          </div><!-- /.row -->
        </form>
      </div>
<?php } else { ?>
     <div class="well well-lg">
        <h2 class="form-signin-heading">Reset your password</h2>
        <form method="post" class="form-signin" role="form">
          <div class="row">
            <div class="col-lg-6">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope" ></span></span>
                <input required pattern="^[a-z0-9åäöÅÄÖ._%+-]+[a-zåäöÅÄÖ0-9]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="reset-mail" type="email" class="form-control" placeholder="E-Mail">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
                  <button name="reset-password" class="btn btn-primary btn-block" type="submit">Reset Password</button>
            </div>  
          </div><!-- /.row -->
        </form>
      </div>
<?php } ?>

<?php includeFooter(); ?>