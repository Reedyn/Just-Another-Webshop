<?php jaws_header(); ?>
<div class="container marketing">

     <div class="well well-lg">
        <h2 class="form-signin-heading"><?php if($_GET['user'] == 'new') { echo "New"; } else { echo "Edit"; }?> User</h2>
        <form class="form-signin" role="form">
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon inputLeft">Social Security Number</span>
                <input type="text" class="form-control" value="199004040204" readonly>
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon inputLeft">First name</span>
                <input type="text" class="form-control" value="Gustav">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 --> 
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon inputLeft">Last Name</span>
                <input type="text" class="form-control" value="Lindqvist">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
          </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon inputLeft">Street Address</span>
                <input type="text" class="form-control" value="Hemreiaj13">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon inputLeft">Post Address</span>
                <input type="text" class="form-control" value="postadressi">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 --> 
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon inputLeft">City</span>
                <input type="text" class="form-control" value="city">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->  
          </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon inputLeft">Phone</span>
                <input type="text" class="form-control" value="phone">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->

          </div><!-- /.row -->

          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <input type="button" class="btn btn-primary" value="New password">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 --> 
            
          </div><!-- /.row -->

          <div class="row">
            <div class="col-lg-4">
              <button class="btn btn-primary btn-block" type="submit">Submit changes</button>
            </div>
          </div>
        </form>
      </div>
<?php jaws_footer(); ?>