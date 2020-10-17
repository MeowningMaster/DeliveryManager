<?php
    require_once('../response.php');
    require_once('../link.php');

    $query = 'DELETE FROM couriers WHERE id = '.$_GET['courier_id'];
    $result = $link->query($query);
    if ($result === false) {
        send($error, $cannot_delete_courier);
    } else {
        send($ok, '');
    }

    $link->close();
?>