<?php
    require_once('../response.php');

    $mysql_host = 'localhost';
    $mysql_db = 'u1113801_delivery_manager';
    $mysql_user = 'u1113801';
    $mysql_password = 'F0s7B4y8';

    $link = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_db);
    if ($link === false) {
        send($error, $cannot_link_database);
        exit();
    }
    $link->set_charset('utf8');
?>