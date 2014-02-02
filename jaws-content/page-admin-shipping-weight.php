<?php jaws_header(); 
if(isset($_POST['shipping-add'])){//dbAddShipping($MaxWeight,$Price)
    if($GLOBALS['db']->dbAddShipping($_POST['shipping-max-weight'],$_POST['shipping-cost'])){
        registerError("Shipping weight successfully added","success");
        redirect();
    } else {
        registerError("Error adding weight","success");
        redirect();
    }
}

?>
<div class="panel panel-primary">
  <div class="panel-heading">Currency</div>
  <div class="panel-body">
    <form method="post" class="form-signin" role="form">
          <div class="row">
            <div class="col-lg-6">
              <div class="input-group">
                <span class="input-group-addon">Max weight (in gram)</span>
                <input pattern="^(\w|\s)+$" required name="shipping-max-weight" type="text" class="form-control" placeholder="2">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
              <div class="input-group">
                <span class="input-group-addon">Shipping Cost (in Euro)</span>
                <input pattern="^(\w|\s)+$" required name="shipping-cost" type="text" class="form-control" placeholder="5">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            </div>
            <div class="row">
                <div class="col-lg-2">
                      <a href="/admin/shipping/" class="btn btn-default btn-block">Back</a>
                </div>
                <div class="col-lg-4">
                </div>
                <div class="col-lg-2">
                      <button name="shipping-delete" class="btn btn-danger btn-block" type="submit" value="new">Delete</button>
                </div>
                <div class="col-lg-4">
                  <button name="shipping-add" class="btn btn-primary btn-block" type="submit" value="new">Add weight</button>
                </div>
            </div>
        </form>
  </div>
</div>

<?php jaws_footer(); ?>