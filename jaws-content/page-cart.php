<?php jaws_header();
if(!isLoggedIn()){ // Prompt user to login when trying
    loginPrompt("Please login to checkout your shopping cart");
}

if(isset($_POST['cart-remove']) && isset($_SESSION['cart'][$_POST['cart-remove']])){ // Remove item from cart when button is pressed.
    unset($_SESSION['cart'][$_POST['cart-remove']]);
    registerError("Item removed from cart","success");
    header('Location: '.$_SERVER['REQUEST_URI']);
    exit();
}

if(isset($_POST['currency']) && !isset($_POST['cart-update'])){ // Set new currency when a new currency is selected.
    $id = intval($_POST['currency']);
    // $db->getCurrency();
    setCurrency($id,"Swedish crowns","kr", "suffix",0.113082696);
    registerError("Currency changed","success");
    redirect();
    
}

if(isset($_POST['cart-update'])){ // Update cart when button is pressed.
    foreach($_POST as $key => $value){ 
        if(isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key] = $value;
        }
    }
    registerError("Cart updated","success");
    redirect();
}
if(isset($_POST['checkout'])){ // If user is trying to checkout
    $remove = array("-", " ");
    $_POST['card-number'] = str_replace($remove, "", $_POST['card-number']);                  
}
                  
?>
      <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading ">Step 1 - Check your cart</div>
        <div class="panel-body">

          <form method="post">
            <table class="table">
              <tr>
                <td>Bauer Skates</td>
                <td>
                  <button type="submit" class="btn btn-default" name="cart-update"> <span class="glyphicon glyphicon-refresh"></span></button>
                </td>
                <td>
                  <div class="col-lg-2">
                   <div class="input-group">
                    <input type="text" class="form-control" name="555" value="1">
                  </div>
                </div>
              </td>
              <td>
                <button class="btn btn-default" name="cart-remove" value="555">Remove</button>
              </td>
              <td>800$</td>
            </tr>
            <tr>
                <td>Bauer Skates</td>
                <td>
                  <button type="submit" class="btn btn-default" name="cart-update"> <span class="glyphicon glyphicon-refresh"></span></button>
                </td>
                <td>
                  <div class="col-lg-2">
                   <div class="input-group">
                    <input type="text" class="form-control" name="666" value="1">
                  </div>
                </div>
              </td>
              <td>
                <button class="btn btn-default" name="cart-remove" value="666">Remove</button>
              </td>
              <td>800$</td>
            </tr>
            </tbody>
            <tfoot>
                <tr>
              <td></td>
              <td></td>
              <td>

                    <div class="input-group">
                        
                        <select class="form-control" name='currency' onchange='this.form.submit()'>
                        <?php
                        $name = "Currency";
                        for($i = 0; $i < 5; $i++){
                            if($i == $_SESSION['currency']['id']){
                                $selected = " selected";
                            } else {
                                $selected = "";
                            }
                            echo '<option value="'.$i.'"'.$selected.'>'.$name.' '.$i.'</option>';
                        }
                        ?>
                        </select>
                        <noscript><input type="submit" value="Submit"></noscript>
                    </div>
              </td>
              <td class="bold">Total Cost</td>
              <td class="bold">900$</td>
            </tr>
                
            </tfoot>

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
                  <input required name="shipping-street-address" type="text" class="form-control" placeholder="Street Address">
                </div>
              </td>
              <td><div class="input-group">
                <span class="input-group-addon inputLeft">Street Address</span>
                <input required name="billing-street-address" type="text" class="form-control" value="Hemreiaj13">
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="input-group">
                <span class="input-group-addon inputLeft">Post Address</span>
                <input required name="shipping-post-address"type="text" class="form-control" value="postadressi">
              </div>
            </td>
            <td>
              <div class="input-group">
                <span class="input-group-addon inputLeft">Post Address</span>
                <input required name="billing-post-address" type="text" class="form-control" value="postadressi">
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="input-group">
                <span class="input-group-addon inputLeft">City</span>
                <input required name="shipping-city" type="text" class="form-control" value="city">
              </div>
            </td>
            <td>
              <div class="input-group">
                <span class="input-group-addon inputLeft">City</span>
                <input required name="billing-city" type="text" class="form-control" value="city">
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
                <input name="card-full-name" required type="text" class="form-control" value="">
              </div>
            </td>
            <td>
              <select required name="card-expiry-month" class="btn btn-default dropdown-toggle" id='expireMM'>
                <option value='false'>Month</option>
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
              <select required name="card-expiry-year" class="btn btn-default dropdown-toggle" id='expireYY'>
                <option value='false'>Year</option>
                <option value='14'>14</option>
                <option value='15'>15</option>
                <option value='16'>16</option>
                <option value='17'>17</option>
                <option value='18'>18</option>
                <option value='19'>19</option>
              </select> 
            </td>
          </tr>
          <tr>
            <td>
              <div class="input-group">
                <span class="input-group-addon inputLeft">Card Number</span>
                <input required pattern="^((4\d{3})|(5[1-5]\d{2})|(6011))-?\s?\d{4}-?\s?\d{4}-?\s?\d{4}|3[4,7]\d{13}$" name="card-number" type="text" class="form-control" value="">
              </div>
            </td>
            <td>
              <div class="input-group">
                <span class="input-group-addon inputLeft">CVC</span>
                <input name="card-cvc" pattern="^\d{3}$" required type="text" class="form-control" value="">
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <a class="btn btn-default" href="/cart/">&laquo; Back</a>
              <button type="submit" class="btn btn-info" name="checkout">Review before placing order</button>
            </td>
            <td></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>


<?php jaws_footer(); ?>