<?php jaws_header();


?>
<div class="panel panel-primary">
  <div class="panel-heading">Shipping</div>
  <div class="panel-body">
    <table id="sortable" class="table">
        <thead>
            <th><button data-sort="shipping-max-weight" class="sort btn btn-default">Max weight</button></th>
            <th><button data-sort="shipping-cost" class="sort btn btn-default">Cost</button></th>
            <th></th>
        </thead>
        <tbody class="list">
            <tr>
                <th class="shipping-max-weight">2 kg</th>
                <th class="shipping-cost">€5</th>
                <th><a class="btn btn-default" href="/admin/shipping/1">View</a></th>
            </tr>
            <tr>
                <th class="shipping-max-weight">5 kg</th>
                <th class="shipping-cost">€10</th>
                <th><a class="btn btn-default" href="/admin/shipping/2">View</a></th>
            </tr>
            <tr>
                <th class="shipping-max-weight">10 kg</th>
                <th class="shipping-cost">€20</th>
                <th><a class="btn btn-default" href="/admin/shipping/3">View</a></th>
            </tr> 
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th><a href="/admin/shipping/new/" class="btn btn-primary">Add package size</a></th>
            </tr> 
        </tfoot>
    </table>
  </div>
</div>
<script>
    var options = {
        valueNames: [ "shipping-max-weight", "shipping-cost" ]
    };
    var sortable = new List("sortable", options);
</script>



<?php jaws_footer(); ?>