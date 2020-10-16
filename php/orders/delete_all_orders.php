<?php
    require_once('../link.php');

    $query = 'DELETE FROM orders';
    $result = $link->query($query);
    if ($result === false) {
        exit('Cannot delete all orders');
    }

    $link->close();
?>