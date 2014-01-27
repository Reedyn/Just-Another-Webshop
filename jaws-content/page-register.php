<?php jaws_header(); 

/* Server-side validation 
if success, register user and go to homepage. */
if(isset($_POST['user-submit'])) {
    if (isset($_POST['user-ssn']) && preg_match("$\d{2,4}-?\d{2}-?\d{2}-?\d{4}$", $_POST['user-ssn']) &&
        isset($_POST['user-mail']) && preg_match("$[a-z0-9åäöÅÄÖ._%+-]+[a-zåäöÅÄÖ0-9]+@[a-z0-9.-]+\.[a-z]{2,4}$", $_POST['user-mail']) &&
        isset($_POST['user-password']) && preg_match("$[a-zA-ZåäöÅÄÖ0-9]{6,30}$", $_POST['user-password']) &&
        isset($_POST['user-first-name']) && preg_match("$\w+$", $_POST['user-first-name']) &&
        isset($_POST['user-last-name']) && preg_match("$\w+$", $_POST['user-last-name']) &&
        isset($_POST['user-phone']) && preg_match("$(46|\+46|0)(-?\s?[0-9]+)+$", $_POST['user-phone'])) {
        registerError("Registration successful", "success");
        header("Location: /login/"); exit();       
    } else {
        showError("Registration failed.", "danger");
    }
}
      
?>
      <div class="well well-lg">
        <h2 class="form-signin-heading">Register</h2>
        <form method="post" class="form-signin" role="form">
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
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
                <input pattern="^[a-zA-ZåäöÅÄÖ0-9]{6,30}$" required name="user-password" type="password" class="form-control" placeholder="Password">
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
                <input pattern="^(46|\+46|0)(-?\s?[0-9]+)+$" name="user-phone" type="tel" class="form-control" placeholder="Phone">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 --> 
            </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="user-street-address" type="text" class="form-control" placeholder="Street Address">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="user-post-address" type="text" class="form-control" placeholder="Post Address">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->  
          
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="user-city" type="text" class="form-control" placeholder="City">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
          </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-2">
              <button name="user-submit" class="btn btn-primary btn-block" type="submit">Sign up</button>
            </div>
          </div>
        </form>
      </div>

      <!-- START THE FEATURETTES -->

      <hr class="featurette-divider">
<?php jaws_footer(); ?>