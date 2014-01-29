<?php jaws_header(); ?>
<div class="panel panel-primary">
  <div class="panel-heading">Currencies</div>
  <div class="panel-body">
    <table class="sortable table">
        <thead>
            <th><button class="btn btn-default">Currency</button></th>
            <th><button class="btn btn-default">Value (in relation to Euro)</button></th>
            <th></th>
        </thead>
        <tbody>
            <tr>
                <th>SEK</th>
                <th>0.113498611</th>
                <th><a class="btn btn-default btn-xs" href="/admin/currencies/1">View</a></th>
            </tr>
            <tr>
                <th>Euro</th>
                <th>1</th>
                <th><a class="btn btn-default btn-xs" href="/admin/currencies/2">View</a></th>
            </tr>
            <tr>
                <th>USD</th>
                <th>0.731314904</th>
                <th><a class="btn btn-default btn-xs" href="/admin/currencies/3">View</a></th>
            </tr> 
        </tbody>
        <tfoot></tfoot>
    </table>
  </div>
</div>

<?php jaws_footer(); ?>