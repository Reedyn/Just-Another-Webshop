<?php

    include "functions.php";
    include_once "db.php";
    //$db->dbAddUser("12345","asd@asd.asd","password","asd","asd","asd","asd","asd","asd");
    //listProducts("admin","ALL");
    //listProducts('thumbnail','ALL');
    //listOrders("userorders","199205075931");
    //var_dump($db->dbGetUsersAll());

    $ip=$_SERVER['REMOTE_ADDR'];

    //$db->dbAddOrder(621955621955,0,1,$ip,9,3,8,2,7,1);
    //var_dump(getOrder(4));
    var_dump($db->dbGetOrder(4));

?>