<?php
    require_once('../response.php');
    require_once('../link.php');

    $query = 'DELETE FROM operators WHERE id = '.$_GET['operator_id'];
    $result = $link->query($query);
    if ($result === false) {
        send($error, $cannot_delete_operator);
    } else {
        send($ok, '');
    }

    $link->close();
?>