<?php
    require_once('../response.php');

    $mysql_host = 'localhost';
    $mysql_db = 'main';
    $mysql_user = 'master';
    $mysql_password = 'fR0eE5oJ3wuW0f';

    $link = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_db);
    if ($link === false) {
        send($error, $cannot_link_database);
        exit();
    }
    $link->set_charset('utf8');
?>