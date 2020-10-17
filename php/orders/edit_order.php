<?php
    require_once('../response.php');
    require_once('../link.php');

    $query = 'UPDATE orders ';
    $query .= 'SET `status` = '.$_GET['status'].', `client` = '.$_GET['client'].', `contacts` = '.$_GET['contacts'].' ';
    $query .= ', `city` = '.$_GET['city'].', `address` = '.$_GET['address'].', `date` = '.$_GET['date'].' ';
    $query .= ', `time` = '.$_GET['time'].', `cost` = '.$_GET['cost'].', `details` = '.$_GET['details'].' ';
    $query .= ', `courier_id` = '.$_GET['courier_id'].' ';
    $query .= 'WHERE `id` = '.$_GET['id'];

    $result = $link->query($query);
    if ($result === false) {
        send($error, $cannot_edit_order);
    } else {
        send($ok, '');
    }

    $link->close();
?>