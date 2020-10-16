<?php
    require_once('../link.php');

    $query = 'SELECT * FROM couriers';
    $result = $link->query($query);
    if ($result === false) {
        exit('Cannot query couriers');
    }

    $couriers = [];
    while($row = mysqli_fetch_assoc($result)) {
        $couriers[] = $row;
    }

    echo json_encode($couriers);
    $result->close();
    $link->close();
?>