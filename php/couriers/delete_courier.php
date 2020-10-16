<?php
    require_once('../link.php');

    $query = 'DELETE FROM couriers WHERE id = '.$_GET['courier_id'];
    $result = $link->query($query);
    if ($result === false) {
        exit('Cannot delete courier');
    }

    $link->close();
?>