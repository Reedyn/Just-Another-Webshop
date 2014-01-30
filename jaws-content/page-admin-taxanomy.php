<?php jaws_header(); ?>
<div class="panel panel-primary">
  <div class="panel-heading">Category</div>
  <div class="panel-body">
    <form method="post" class="form-signin" role="form">
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon"></span>
                <input pattern="^\w+$" required name="taxanomy-name" type="text" class="form-control" placeholder="Category Name">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-4">
               <div class="input-group">
                <span class="input-group-addon">Parent</span>
                <select class="form-control" name="taxanomy-parent">
                  <option value="false">None</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </div>
            <div class="col-lg-2">
                  <button name="taxanomy-delete" class="btn btn-danger btn-block" type="submit" value="delete">Delete</button>
            </div>
            <div class="col-lg-2">
                  <button name="taxanomy-add" class="btn btn-primary btn-block" type="submit" value="new">Add category</button>
            </div>
            </div><!-- /.row -->
            <div class="row">
                <div class="col-lg-2">
                      <a href="/admin/categories/" class="btn btn-default btn-block">Back</a>
                </div>
            </div>
        </form>
  </div>
</div>

<?php jaws_footer(); ?>