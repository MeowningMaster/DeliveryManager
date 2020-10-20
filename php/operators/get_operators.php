<?php
    require_once('../response.php');
    require_once('../link.php');

    $query = 'SELECT * FROM operators';
    $result = $link->query($query);
    if ($result === false) {
        send($error, $cannot_get_operators);
    } else {
        $operators = [];
        while($row = mysqli_fetch_assoc($result)) {
            $operators[] = $row;
        }

        send($ok, $operators);
    }

    $link->close();
?>