<?php jaws_header(); ?>
<div class="panel panel-primary">
  <div class="panel-heading">Currency</div>
  <div class="panel-body">
    <form method="post" class="form-signin" role="form">
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input pattern="^\w+$" required name="currency-name" type="text" class="form-control" placeholder="Currency Name">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input pattern="^(\d|[\.])+$" required name="currency-value" type="text" class="form-control" placeholder="Currency value in relation to Euro">
              </div><!-- /input-group -->
            </div>
            <div class="col-lg-2">
                  <button name="currency-add" class="btn btn-primary btn-block" type="submit" value="new">Add currency</button>
            </div>
            <div class="col-lg-2">
                  <button name="currency-delete" class="btn btn-danger btn-block" type="submit" value="new">Delete</button>
            </div>
            </div><!-- /.row -->
        </form>
  </div>
</div>

<?php jaws_footer(); ?>