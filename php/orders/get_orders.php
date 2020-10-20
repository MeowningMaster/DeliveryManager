<?php
    require_once('../response.php');
    require_once('../link.php');

    $query = 'SELECT `id`, `status`, `client`, `contacts`, `city`, `address`, DATE_FORMAT(`date`, "%m/%d/%Y") AS `date`, DATE_FORMAT(`time`, "%H:%i") AS `time`, `cost`, `details`, `courier_id` FROM `orders`';

    $count = count($_GET);
    if ($count > 0) {
        $query .= ' WHERE ';

        $first = true;
        foreach ($_GET as $key => $value) {
            if ($first) {
                $first = false;
            } else {
                $query .= ' AND ';
            }

            $query .= '`'.$key.'`="'.$value.'"';
        }
    }

    $result = $link->query($query);
    if ($result === false) {
         send($error, $cannot_get_orders);
    } else {
        $orders = [];
        while($row = mysqli_fetch_assoc($result)) {
            $orders[] = $row;
        }

        send($ok, $orders);
    }

    $link->close();
?>