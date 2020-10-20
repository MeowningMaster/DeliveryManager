<?php
    require_once('../response.php');
    require_once('../link.php');

    $query = 'INSERT operators(`name`, `status`, `contacts`) ';
    $query .= 'VALUES('.$_GET['name'].','.$_GET['status'].','.$_GET['contacts'].')';
    $result = $link->query($query);
    if ($result === false) {
        send($error, $cannot_add_operator);
    } else {
        send($ok, "$link->insert_id");
    }

    $link->close();
?>