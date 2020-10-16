<?php
    require_once('../link.php');

    $query = 'INSERT couriers(`name`, `status`, `contacts`) ';
    $query .= 'VALUES('.$_GET['name'].','.$_GET['status'].','.$_GET['contacts'].')';
    $result = $link->query($query);
    if ($result === false) {
        exit('Cannot add courier');
    }

    $query = 'SELECT MAX(id) FROM couriers';
    $result = $link->query($query);
    if ($result === false) {
        exit('Cannot query couriers max(id)');
    }

    $max = mysqli_fetch_assoc($result);

    echo $max['MAX(id)'];
    $result->close();
    $link->close();
?>