<?php
    include 'db.php';

    $dbHost = "localhost";
    $dbUser = "root";
    $dbPassword = "621955";
    $dbName = "jaws_db";

    $db = new Database($dbHost,$dbUser,$dbPassword,$dbName);
    $db->getUser(199205075931);
?>