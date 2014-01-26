<?php jaws_header(); ?>
<div class="container marketing">




      <div class="well well-lg">
        <h2 class="form-signin-heading">Register</h2>
        <form method="post" class="form-signin" role="form">
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="user-ssn" type="text" class="form-control" placeholder="Social Security Number">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope" ></span></span>
                <input name="user-mail" type="text" class="form-control" placeholder="E-Mail">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 --> 
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="user-first-name" type="text" class="form-control" placeholder="First Name">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
          </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="user-last-name" type="text" class="form-control" placeholder="Last Name">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
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
          </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="user-city" type="text" class="form-control" placeholder="City">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-earphone" ></span></span>
                <input name="user-phone" type="text" class="form-control" placeholder="Phone">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 --> 
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock" ></span></span>
                <input name="user-password" type="password" class="form-control" placeholder="Password">
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