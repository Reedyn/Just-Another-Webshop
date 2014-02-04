<?php includeHeader();
    listAdminCurrencies();
?>
<script>
    var options = {
        valueNames: [ "currency-name", "currency-value" ]
    };
    var sortable = new List("sortable", options);
</script>


<?php includeFooter(); ?>