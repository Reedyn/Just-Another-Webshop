<?php

    //include 'functions.php';
    include 'db.php';
    include 'config.php';
    $db=new Database($dbHost,$dbUser,$dbPassword,$dbName);

    $db->dbGetOrders("ALL");

    //listProducts('thumbnail','ALL');
?>