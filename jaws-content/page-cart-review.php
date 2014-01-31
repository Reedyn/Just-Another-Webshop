<?php jaws_header(); 

if(!isset($_SESSION['cart'])){
    registerError("Your cart is empty, please add a product before trying to checkout", "warning");
    redirect("/");
}
      
if(isset($_POST['place-order'])){
    if(true){ // try to add order to database
        unset($_SESSION['cart']);
        registerError("Thank you for your order! You can see your orders here","success");
        redirect("/settings/orders/");
    } else {
        registerError("Something went wrong when trying to place your order","danger");
        redirect();
    }   
}
    ?>
      <div class="panel panel-primary">
        <div class="panel-heading ">Check your cart</div>
        <div class="panel-body">

          <form>
            <table class="table">
              <tr>
                <td>Bauer blabla</td>
                <td>
                </td>
                <td>
                  <div class="col-lg-2">
                   <div class="input-group">
                    <input type="text" class="form-control" value="1" readonly>
                  </div>
                </div>
              </td>
              <td>
              </td>
              <td>450$</td>
            </tr>
            <tr>
              <td>Jofa blabla</td>
              <td>
              </td>
              <td> <div class="col-lg-2">
               <div class="input-group">
                <input type="text" class="form-control" value="1" readonly>
              </div>
            </div>
          </td>
          <td>
          </td>
          <td>450$</td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td class="bold">Total Cost</td>
          <td class="bold">900$</td>
        </tr>

      </table>
    </form>


  </div>
   <div class="panel-heading">Personal information</div>
   <div class="panel-body">
     <form method="post" action="/cart/review/">
      <table class="table">
        <tr>
          <th>Full Name</th>
          <th>Gustav Lindqvist</th>
        </tr>
        <tr>
          <th>Shipping Address</th>
          <th>Billing Address</th>
        </tr>
        <tr>
          <td>
            <div class="input-group">
              <span class="input-group-addon inputLeft">Street Address</span>
              <input type="text" class="form-control" value="<?php fillForm("cart","shipping-street-address"); ?>" readonly>
            </div>
          </td>
          <td><div class="input-group">
            <span class="input-group-addon inputLeft">Street Address</span>
            <input type="text" class="form-control" value="<?php fillForm("cart","billing-street-address"); ?>" readonly>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="input-group">
            <span class="input-group-addon inputLeft">Post Address</span>
            <input type="text" class="form-control" value="<?php fillForm("cart","shipping-post-address"); ?>" readonly>
          </div>
        </td>
        <td>
          <div class="input-group">
            <span class="input-group-addon inputLeft">Post Address</span>
            <input type="text" class="form-control" value="<?php fillForm("cart","billing-post-address"); ?>" readonly>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="input-group">
            <span class="input-group-addon inputLeft">City</span>
            <input type="text" class="form-control" value="<?php fillForm("cart","shipping-city"); ?>" readonly>
          </div>
        </td>
        <td>
          <div class="input-group">
            <span class="input-group-addon inputLeft">City</span>
            <input type="text" class="form-control" value="<?php fillForm("cart","billing-city"); ?>" readonly>
          </div>
        </td>
      </tr>
      <tr>
        <th>Credit Card</th>
      </tr>
      <tr>
        <td>
          <div class="input-group">
            <span class="input-group-addon inputLeft">Full Name</span>
            <input type="text" class="form-control" value="<?php fillForm("cart","card-full-name"); ?>" readonly>
          </div>
        </td>
        <td>
          <div class="input-group">
            <span class="input-group-addon inputLeft">Card Number</span>
            <input type="text" class="form-control" value="<?php fillForm("cart","card-number"); ?>" readonly>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="input-group">
            <span class="input-group-addon inputLeft">Month</span>
          <input type="text" class="form-control" value="<?php fillForm("cart","card-expiry-month"); ?>" readonly>
          </div>
        </td>
        <td>
        <div class="input-group">
            <span class="input-group-addon inputLeft">Year</span>
        <input type="text" class="form-control" value="<?php fillForm("cart","card-expiry-year"); ?>" readonly>
        </div>
        </td>
      </tr>
      <tr>
        <td>
          <a class="btn btn-default" href="/cart/">Back</a>
          <button type="submit" class="btn btn-info" name="place-order">Place order</button>
        </td>
        <td></td>
      </tr>
    </table>
  </form>
</div>
</div>
<?php jaws_footer(); ?>