<?php
    require_once('../link.php');

    $query = 'INSERT orders(`status`, `client`, `contacts`, `city`, `address`, `date`, `time`, `cost`, `details`, `courier_id`) ';
    $query .= 'VALUES('.$_GET['status'].','.$_GET['client'].','.$_GET['contacts'].','.$_GET['city'].','.$_GET['address'].','.$_GET['date'].','.$_GET['time'].','.$_GET['cost'].','.$_GET['details'].','.$_GET['courier_id'].')';
    $result = $link->query($query);
    if ($result === false) {
        exit('Cannot edit order');
    }

    $link->close();
?>