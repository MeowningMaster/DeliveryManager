<?php
    require_once('../link.php');

    $query = 'INSERT orders(`status`, `client`, `contacts`, `city`, `address`, `date`, `time`, `cost`, `details`, `courier_id`) ';
    $query .= 'VALUES('.$_GET['status'].','.$_GET['client'].','.$_GET['contacts'].','.$_GET['city'].','.$_GET['address'].','.$_GET['date'].','.$_GET['time'].','.$_GET['cost'].','.$_GET['details'].','.$_GET['courier_id'].')';
    $result = $link->query($query);
    if ($result === false) {
        die('Cannot add order');
    }

    $query = 'SELECT MAX(id) FROM orders';
    $result = $link->query($query);
    if ($result === false) {
        die('Cannot query max(id)');
    }

    $max = mysqli_fetch_assoc($result);

    echo $max['MAX(id)'];
    $result->close();
    $link->close();
?>