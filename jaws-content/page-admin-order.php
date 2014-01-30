<?php jaws_header(); 
      if(isset($_POST['order-delete'])) {
          registerError("Order deleted","danger");
          redirect();
      }
      
      ?>
      <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading ">Order</div>
        <div class="panel-body">
          <table class="table">
            <th>Invoice 123123</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <tr>
              <td class="bold">Costumer</td>
              <td></td>
              <td class="bold">Gustav Lindqvist</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="bold">Ordernumber</td>
              <td></td>
              <td>3928392</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="bold">Date of purchase</td>
              <td></td>
              <td>2013-11-11</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="bold">Name</td>
              <td class="bold">Price</td>
              <td class="bold">Amount</td>
              <td class="bold">Reserved</td>
              <td class="bold">Sent</td>
              <td class="bold">Cost</td>
            </tr>
            <tr>
              <td>Bauer 145 skates blue, sm</td>
              <td>359$</td>
              <td>1</td>
              <td>0</td>
              <td>1</td>
              <td class="bold">359$</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="bold">Shipping cost</td>
              <td class="bold">20$</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="bold">Total cost, including shipping etc..</td>
              <td class="bold">419$</td>
            </tr>
          </table>

          <table>
            <tr>
              <td><a class="btn btn-default" href="/admin/orders/">Back</a></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td><form method="post"><button type="submit" name="order-delete" class="btn btn-danger" value="<?php echo $_GET['order']; ?>">Delete order</button></form></td>
            </tr>
          </table>


        </div>

      </div>

      <!-- START THE FEATURETTES -->
<?php jaws_footer(); ?>