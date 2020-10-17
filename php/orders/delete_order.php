<?php
    require_once('../response.php');
    require_once('../link.php');

    $query = 'DELETE FROM orders WHERE id = '.$_GET['order_id'];
    $result = $link->query($query);
    if ($result === false) {
        send($error, $cannot_delete_order);
    } else {
        send($ok, '');
    }

    $link->close();
?>