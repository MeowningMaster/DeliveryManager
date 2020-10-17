<?php
    require_once('../response.php');
    require_once('../link.php');

    $query = 'INSERT orders(`status`, `client`, `contacts`, `city`, `address`, `date`, `time`, `cost`, `details`, `courier_id`) ';
    $query .= 'VALUES('.$_GET['status'].','.$_GET['client'].','.$_GET['contacts'].','.$_GET['city'].','.$_GET['address'].','.$_GET['date'].','.$_GET['time'].','.$_GET['cost'].','.$_GET['details'].','.$_GET['courier_id'].')';
    $result = $link->query($query);
    if ($result === false) {
       send($error, $cannot_add_order);
    } else {
        $query = 'SELECT MAX(id) FROM orders';
        $result = $link->query($query);
        if ($result === false) {
            send($error, $cannot_get_new_order_id);
        } else {
            $row = mysqli_fetch_assoc($result);
            $max = $row['MAX(id)'];
            send($ok, $max);
            $result->close();
        }
    }

    $link->close();
?>