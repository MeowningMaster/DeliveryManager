<?php
    require_once('../response.php');
    require_once('../link.php');

    $query = 'SELECT * FROM orders';
    $result = $link->query($query);
    if ($result === false) {
         send($error, $cannot_get_orders);
    } else {
        $orders = [];
        while($row = mysqli_fetch_assoc($result)) {
            $orders[] = $row;
        }

        send($ok, $orders);
        $result->close();
    }

    $link->close();
?>