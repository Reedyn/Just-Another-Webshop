<?php jaws_header();?>
      <div class="container marketing">
      <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading "><?php if($_GET['product'] == 'new') { echo "New"; } else { echo "Edit"; }?> Product</div>
        <div class="panel-body">
          <form method="post" class="form-signin" role="form">
            Name
            <input pattern="^.+$"name="product-name" type="text" class="form-control" value="hejhe">
            description
            <textarea pattern="^.+$" name="product-description" type="text" id="mBot" rows="10" class="form-control">dsasdasdaisdaiuhdsaiuhdasiuhdsaiu aisuhdisuah iuasdhiaushd</textarea>
            <div class="row">
              <div class="col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon">Product ID</span>
                  <input pattern="^\d+$" name="product-id" type="text" class="form-control" value="342234234">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon">Price (in SEK)</span>
                  <input name="product-price" type="text" pattern="^\d+$" class="form-control" value="421$">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon">Currently in stock</span>
                  <input pattern="^\d+$" name="product-stock" type="text" class="form-control" value="1">
                </div>
              </div>
              <div class="col-lg-4">
               <div class="input-group">
                <span class="input-group-addon">Weight (in gram)</span>
                <input pattern="^\d+$" name="product-weight" type="text" class="form-control" value="1.4">
              </div>
            </div>
              <div class="col-lg-4">
               <div class="input-group">
                <span class="input-group-addon">Category</span>
                <select class="form-control" name="product-category">
                  <option value="false">None</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </div>
              <div class="col-lg-4">
                <span class="btn btn-default btn-file">Browse image<input name="product-image" type="file">
                </span>
              </div>
          </div>
          <tr>
            <td>
              <button name="submit" class="btn btn-primary btn-block" type="submit">Submit changes</button>
            </td>
          </tr>
        </form>
      </div>
    </div>
<?php jaws_footer(); ?>