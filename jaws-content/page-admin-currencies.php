<?php jaws_header();
    listAdminCurrencies();
?>
<script>
    var options = {
        valueNames: [ "currency-name", "currency-value" ]
    };
    var sortable = new List("sortable", options);
</script>


<?php jaws_footer(); ?>