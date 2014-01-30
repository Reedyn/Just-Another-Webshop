<?php jaws_header(); ?>
<div class="panel panel-primary">
  <div class="panel-heading">Currency</div>
  <div class="panel-body">
    <form method="post" class="form-signin" role="form">
          <div class="row">
            <div class="col-lg-2">
              <div class="input-group">
                <span class="input-group-addon">ID</span>
                <input pattern="^(\w|\s)+$" readonly name="currency-id" type="text" class="form-control" title="Automatically generated">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon">Name</span>
                <input pattern="^(\w|\s)+$" required name="currency-name" type="text" class="form-control" placeholder="Euro">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-2">
              <div class="input-group">
                <span class="input-group-addon">Sign</span>
                <input pattern="^.{0,4}$" required name="currency-sign" type="text" class="form-control" placeholder="€">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-2">
              <div class="input-group">
                <span class="input-group-addon">Value</span>
                <input pattern="^(\d|[\.])+$" required name="currency-value" type="text" class="form-control" placeholder="1.0">
              </div><!-- /input-group -->
            </div>
            <div class="col-lg-2">
               <div class="input-group">
                <span class="input-group-addon">Position</span>
                <select class="form-control" name="currency-position">
                  <option value="prefix">Prefix</option>
                  <option value="suffix">Suffix</option>
                </select>
              </div>
            </div>
            
            </div><!-- /.row -->
            <div class="row">
                <div class="col-lg-2">
                      <a href="/admin/currencies/" class="btn btn-default btn-block">Back</a>
                </div>
                <div class="col-lg-4">
                </div>
                <div class="col-lg-2">
                      <button name="currency-delete" class="btn btn-danger btn-block" type="submit" value="new">Delete</button>
                </div>
                <div class="col-lg-4">
                  <button name="currency-add" class="btn btn-primary btn-block" type="submit" value="new">Add currency</button>
                </div>
            </div>
            
        </form>
  </div>
</div>

<?php jaws_footer(); ?>