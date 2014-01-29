<?php jaws_header(); ?>
      <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading ">Step 1 - Check your cart</div>
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
  <div class="panel-heading ">Step 2 - Payment method</div>
  <div class="panel-body">
   <input type="radio" checked="1" name="c1" onclick="showMe('div1')">Credit Card

 </div>
   <div class="panel-heading">Step 3 - Personal information</div>
   <div class="panel-body">
     <form>
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
              <input type="text" class="form-control" value="Hemreiaj13" readonly>
            </div>
          </td>
          <td><div class="input-group">
            <span class="input-group-addon inputLeft">Street Address</span>
            <input type="text" class="form-control" value="Hemreiaj13" readonly>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="input-group">
            <span class="input-group-addon inputLeft">Post Address</span>
            <input type="text" class="form-control" value="postadressi" readonly>
          </div>
        </td>
        <td>
          <div class="input-group">
            <span class="input-group-addon inputLeft">Post Address</span>
            <input type="text" class="form-control" value="postadressi" readonly>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="input-group">
            <span class="input-group-addon inputLeft">City</span>
            <input type="text" class="form-control" value="city" readonly>
          </div>
        </td>
        <td>
          <div class="input-group">
            <span class="input-group-addon inputLeft">City</span>
            <input type="text" class="form-control" value="city" readonly>
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
            <input type="text" class="form-control" value="Gustav Lindqvist" readonly>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="input-group">
            <span class="input-group-addon inputLeft">Card Number</span>
            <input type="text" class="form-control" value="4214142141" readonly>
          </div>
        </td>
        <td>
          <div class="input-group">
            <span class="input-group-addon inputLeft">cvc</span>
            <input type="text" class="form-control" value="321" readonly>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <select name='expireMM' disabled="disabled" class="btn btn-default dropdown-toggle" id='expireMM'>
            <option value='' readonly>April</option>
          </select> 
          <select name='expireYY' disabled="disabled" class="btn btn-default dropdown-toggle" id='expireYY'>
            <option value='' >15</option>
          </select> 
        </td>
        <td>
        </td>
      </tr>
      <tr>
        <td>
          <input class="btn btn-default" href="page-product.php" type="button" value="back">
          <button type="submit" class="btn btn-info">Place order</button>
        </td>
        <td></td>
      </tr>
    </table>
  </form>
</div>
</div>
<?php jaws_footer(); ?>