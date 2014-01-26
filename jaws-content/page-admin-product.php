<?php jaws_header(); ?>
      <div class="container marketing">
      <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading "><?php if($_GET['product'] == 'new') { echo "New"; } else { echo "Edit"; }?> Product</div>
        <div class="panel-body">
          <form class="form-signin" role="form">
            Name
            <input type="text" class="form-control" value="hejhe">
            description
            <textarea type="text" id="mBot" rows="10" class="form-control">dsasdasdaisdaiuhdsaiuhdasiuhdsaiu aisuhdisuah iuasdhiaushd</textarea>
            <div class="row">
              <div class="col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon">Product ID</span>
                  <input type="text" class="form-control" value="342234234">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon">Price</span>
                  <input type="text" class="form-control" value="421$">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon">Currently in stock</span>
                  <input type="text" class="form-control" value="1">
                </div>
              </div>
              <div class="col-lg-4">
               <div class="input-group">
                <span class="input-group-addon">Weight</span>
                <input type="text" class="form-control" value="1.4">
              </div>
            </div>
              <div class="col-lg-4">
                <span class="btn btn-default btn-file">Browse image<input type="file">
                </span>
              </div>
          </div>
          <tr>
            <td>
              <button class="btn btn-primary btn-block" type="submit">Submit changes</button>
            </td>
          </tr>
        </form>
      </div>
    </div>
<?php jaws_footer(); ?>