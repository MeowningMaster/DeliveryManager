<?php
    require_once('../response.php');
    require_once('../link.php');

    $query = 'INSERT couriers(`name`, `status`, `contacts`) ';
    $query .= 'VALUES('.$_GET['name'].','.$_GET['status'].','.$_GET['contacts'].')';
    $result = $link->query($query);
    if ($result === false) {
        send($error, $cannot_add_courier);
    } else {
        $query = 'SELECT MAX(id) FROM couriers';
        $result = $link->query($query);
        if ($result === false) {
            send($error, $cannot_get_new_courier_id);
        } else {
            $row = mysqli_fetch_assoc($result);
            $max = $row['MAX(id)'];
            send($ok, $max);
            $result->close();
        }
    }

    $link->close();
?>