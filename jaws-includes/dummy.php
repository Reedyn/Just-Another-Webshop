<?php

    //include 'functions.php';
    include 'db.php';
    include 'config.php';
    $db=new Database($dbHost,$dbUser,$dbPassword,$dbName);

    $db->dbGetUsersOrders(199205075931);

    //listProducts('list','ALL');
?>