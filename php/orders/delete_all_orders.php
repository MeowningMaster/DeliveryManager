<?php
    require_once('../response.php');
    require_once('../link.php');

    $query = 'DELETE FROM orders';
    $result = $link->query($query);
    if ($result === false) {
        send($error, $cannot_delete_all_orders);
    } else {
        send($ok, '');
    }

    $link->close();
?>