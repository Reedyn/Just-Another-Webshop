<?php
    include 'db.php';
    include 'config.php';

    $db = new Database($dbHost,$dbUser,$dbPassword,$dbName);
    $db->dbEditUser("199205075931","Password","123456");
?>