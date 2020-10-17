<?php
    require_once('../response.php');
    require_once('../link.php');

    $query = 'SELECT * FROM couriers';
    $result = $link->query($query);
    if ($result === false) {
        send($error, $cannot_get_couriers);
    } else {
        $couriers = [];
        while($row = mysqli_fetch_assoc($result)) {
            $couriers[] = $row;
        }

        send($ok, $couriers);
        $result->close();
    }

    $link->close();
?>