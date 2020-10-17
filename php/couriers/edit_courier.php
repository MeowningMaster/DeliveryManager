<?php
    require_once('../response.php');
    require_once('../link.php');

    $query = 'UPDATE couriers ';
    $query .= 'SET `name` = '.$_GET['name'].', `status` = '.$_GET['status'].', `contacts` = '.$_GET['contacts'].' ';
    $query .= 'WHERE `id` = '.$_GET['id'];
    $result = $link->query($query);
    if ($result === false) {
        send($error, $cannot_edit_courier);
    } else {
        send($ok, '');
    }

    $link->close();
?>