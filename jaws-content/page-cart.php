<?php jaws_header(); ?>
    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">

      <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading ">Step 1 - Check your cart</div>
        <div class="panel-body">

          <form action="/cart/" method="post">
            <table class="table">
              <tr>
                <td>Bauer blabla</td>
                <td>
                  <button type="submit"> <span class="glyphicon glyphicon-refresh"></span></button>
                </td>
                <td>
                  <div class="col-lg-2">
                   <div class="input-group">
                    <input type="text" class="form-control" value="1">
                  </div>
                </div>
              </td>
              <td>
                <input href="#" type="button" class="btn btn-default" value="remove">
              </td>
              <td>450$</td>
            </tr>
            <tr>
              <td>Jofa blabla</td>
              <td>
                <button type="submit"> <span class="glyphicon glyphicon-refresh"></span></button>
              </td>
              <td> <div class="col-lg-2">
                   <div class="input-group">
                    <input type="text" class="form-control" value="1">
                  </div>
                </div>
              </td>
              <td>
                <input href="#" type="button" class="btn btn-default" value="remove">
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
      <div class="panel-heading ">Step 2 - Payment method</div>
      <div class="panel-body">
       <input type="radio" name="c1" onclick="showMe('div1')">Credit Card

     </div>
     <div id="div1">
       <div class="panel-heading">Step 3 - Personal information</div>
       <div class="panel-body">
         <form action="/cart/" method="post">
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
                  <input name="shipping-street-address" type="text" class="form-control" value="Hemreiaj13">
                </div>
              </td>
              <td><div class="input-group">
                <span class="input-group-addon inputLeft">Street Address</span>
                <input name="billing-street-address" type="text" class="form-control" value="Hemreiaj13">
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="input-group">
                <span class="input-group-addon inputLeft">Post Address</span>
                <input name="shipping-post-address"type="text" class="form-control" value="postadressi">
              </div>
            </td>
            <td>
              <div class="input-group">
                <span class="input-group-addon inputLeft">Post Address</span>
                <input name="billing-post-address" type="text" class="form-control" value="postadressi">
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="input-group">
                <span name="shipping-city" class="input-group-addon inputLeft">City</span>
                <input type="text" class="form-control" value="city">
              </div>
            </td>
            <td>
              <div class="input-group">
                <span class="input-group-addon inputLeft">City</span>
                <input name="billing-city"type="text" class="form-control" value="city">
              </div>
            </td>
          </tr>
          <tr>
            <th>Credit Card</th>
          </tr>
          <tr>
            <td>
              <div class="input-group">
                <span name="card-full-name"class="input-group-addon inputLeft">Full Name</span>
                <input type="text" class="form-control" value="">
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="input-group">
                <span name="card-number"class="input-group-addon inputLeft">Card Number</span>
                <input type="text" class="form-control" value="">
              </div>
            </td>
            <td>
              <div class="input-group">
                <span name="card-cvc"class="input-group-addon inputLeft">cvc</span>
                <input type="text" class="form-control" value="">
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <select name="card-expiry-month" class="btn btn-default dropdown-toggle" id='expireMM'>
                <option value=''>Month</option>
                <option value='01'>Janaury</option>
                <option value='02'>February</option>
                <option value='03'>March</option>
                <option value='04'>April</option>
                <option value='05'>May</option>
                <option value='06'>June</option>
                <option value='07'>July</option>
                <option value='08'>August</option>
                <option value='09'>September</option>
                <option value='10'>October</option>
                <option value='11'>November</option>
                <option value='12'>December</option>
              </select> 
              <select name="card-expiry-year" class="btn btn-default dropdown-toggle" id='expireYY'>
                <option value=''>Year</option>
                <option value='10'>14</option>
                <option value='11'>15</option>
                <option value='12'>16</option>
                <option value='12'>17</option>
                <option value='12'>18</option>
                <option value='12'>19</option>
              </select> 
            </td>
            <td>
            </td>
          </tr>
          <tr>
            <td>
              <a class="btn btn-default" href="page-product.php" role="button">&laquo; Back</a>
              <button type="submit" class="btn btn-info">Review before placing order</button>
            </td>
            <td></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<!-- START THE FEATURETTES -->

<hr class="featurette-divider">


<?php jaws_footer(); ?>