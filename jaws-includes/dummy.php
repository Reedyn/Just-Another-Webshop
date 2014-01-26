<?php

    include "functions.php";
    include_once "db.php";
    //$db->dbAddUser("12345","asd@asd.asd","password","asd","asd","asd","asd","asd","asd");
    //listProducts("admin","ALL");
    //listProducts('thumbnail','ALL');
    //listOrders("userorders","199205075931");
    var_dump($db->dbGetUsersAll());
?>