<?php
    mb_internal_encoding("UTF-8");

    class Response {
        public $status;
        public $data;
    }

    $cannot_link_database = 'Нет доступа к базе данных';

    $cannot_get_orders = 'Не удаеться загрузить список заказов';
    $cannot_add_order = 'Не удаеться добавить заказ';
    $cannot_delete_order = 'Не удаеться удалить заказ';
    $cannot_edit_order = 'Не удаеться изменить данные заказа';

    $cannot_get_couriers = 'Не удаеться загрузить список курьеров';
    $cannot_add_courier = 'Не удаеться добавить курьера';
    $cannot_delete_courier = 'Не удаеться удалить курьера';
    $cannot_edit_courier = 'Не удаеться изменить данные курьера';
    
    $cannot_get_operators = 'Не удаеться загрузить список операторов';
    $cannot_add_operator = 'Не удаеться добавить оператора';
    $cannot_delete_operator = 'Не удаеться удалить оператора';
    $cannot_edit_operator = 'Не удаеться изменить данные оператора';

    $error = 'ERROR';
    $ok = 'OK';

    function send($status, $data) {
        $response = new Response();
        $response->status = $status;
        $response->data = $data;
        echo json_encode($response);
    }
?>