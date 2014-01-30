<?php jaws_header(); ?>
<div class="panel panel-primary">
  <div class="panel-heading">Currencies</div>
  <div class="panel-body">
    <table id="sortable" class="table">
        <thead>
            <th><button data-sort="currency-name" class="sort btn btn-default">Currency</button></th>
            <th><button data-sort="currency-value" class="sort btn btn-default">Value (in relation to Euro)</button></th>
            <th><input placeholder="Search.." class="form-control search"></th>
        </thead>
        <tbody class="list">
            <tr>
                <th class="currency-name">SEK</th>
                <th class="currency-value">0.113498611</th>
                <th><a class="btn btn-default" href="/admin/currencies/1">View</a></th>
            </tr>
            <tr>
                <th class="currency-name">Euro</th>
                <th class="currency-value">1</th>
                <th><a class="btn btn-default" href="/admin/currencies/2">View</a></th>
            </tr>
            <tr>
                <th class="currency-name">USD</th>
                <th class="currency-value">0.731314904</th>
                <th><a class="btn btn-default" href="/admin/currencies/3">View</a></th>
            </tr> 
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th><a href="/admin/currencies/new/" class="btn btn-primary">Add Currency</a></th>
            </tr> 
        </tfoot>
    </table>
  </div>
</div>
<script>
    var options = {
        valueNames: [ "currency-name", "currency-value" ]
    };
    var sortable = new List("sortable", options);
</script>


<?php jaws_footer(); ?>