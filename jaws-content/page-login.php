<?php if(!isLoggedIn() && isset($_POST['login-submit'])) { $_SESSION['logged-in'] = true; header("Location: /"); exit(); } jaws_header(); ?>
<div class="container marketing">

      <div class="well well-lg">
        <h2 class="form-signin-heading">Login</h2>
        <form method="post" class="form-signin" role="form">
          <div class="row">
            <div class="col-lg-6">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user" ></span></span>
                <input name="login-name" type="text" class="form-control" placeholder="Username">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock" ></span></span>
                <input name="login-password" type="password" class="form-control" placeholder="Password">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->  
          </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-2">
              <button name="login-submit"class="btn btn-primary btn-block btn-margin" type="submit">Sign in</button>
            </div>
          </div>
        </form>
      </div>

      <!-- START THE FEATURETTES -->

      <hr class="featurette-divider">
<?php jaws_footer(); ?>