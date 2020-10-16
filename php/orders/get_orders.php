<?php
    require_once('../link.php');

    $query = 'SELECT * FROM orders';
    $result = $link->query($query);
    if ($result === false) {
        exit('Cannot query orders');
    }

    $orders = [];
    while($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }

    echo json_encode($orders);
    $result->close();
    $link->close();
?>