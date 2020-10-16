<?php
    require_once('../link.php');

    $query = 'DELETE FROM orders WHERE id = '.$_GET['order_id'];
    $result = $link->query($query);
    if ($result === false) {
        exit('Cannot delete order');
    }

    $link->close();
?>