<?php jaws_header(); 
if(isset($_POST['user-submit'])) {
    if (isset($_POST['user-ssn']) && preg_match("$\d{2,4}-?\d{2}-?\d{2}-?\d{4}$", $_POST['user-ssn']) &&
        isset($_POST['user-mail']) && preg_match("$[a-z0-9åäöÅÄÖ._%+-]+[a-zåäöÅÄÖ0-9]+@[a-z0-9.-]+\.[a-z]{2,4}$", $_POST['user-mail']) &&
        isset($_POST['user-first-name']) && preg_match("$\w+$", $_POST['user-first-name']) &&
        isset($_POST['user-last-name']) && preg_match("$\w+$", $_POST['user-last-name']) &&
        isset($_POST['user-phone']) && preg_match("$(46|\+46|0)(-?\s?[0-9]+)+$", $_POST['user-phone'])) {
        
        if (isset($_POST['user-password']) && preg_match("$[a-zA-ZåäöÅÄÖ0-9]{6,30}$", $_POST['user-password'])){
            //Change password.
        }
        // Add user to database if successful do
        if (true) {
            registerError('Profile saved','success');
            header('Location: '.$_SERVER['REQUEST_URI']);
            exit(); 
        } else {
            showError("Error while saving profile", "danger");
        }
    } else {
        showError("Error while saving profile", "danger");
    }
}
    
}?>
    <div class="container marketing">
     <div class="well well-lg">
        <h2 class="form-signin-heading">Edit profile</h2>
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
                <input name="user-password" type="password" class="form-control" placeholder="New Password">
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
              <a href="/settings/" class="btn btn-default btn-block">Back</a>
            </div>
            <div class="col-lg-2">
              <button name="user-submit" class="btn btn-primary btn-block" value="edit" type="submit">Save changes</button>
            </div>
          </div>
        </form>
      </div>
      </div>
<?php jaws_footer(); ?>