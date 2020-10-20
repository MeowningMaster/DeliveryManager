<?php
    require_once('../response.php');
    require_once('../link.php');

    $query = 'UPDATE operators ';
    $query .= 'SET `name` = '.$_GET['name'].', `status` = '.$_GET['status'].', `contacts` = '.$_GET['contacts'].' ';
    $query .= 'WHERE `id` = '.$_GET['id'];
    $result = $link->query($query);
    if ($result === false) {
        send($error, $cannot_edit_operator);
    } else {
        send($ok, '');
    }

    $link->close();
?>