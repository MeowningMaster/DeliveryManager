<?php
    require_once(__DIR__.'../response.php');
    require_once(__DIR__.'../connection.php');
    require_once(__DIR__.'../data/account.php');
    require_once(__DIR__.'../data/order.php');

    if (array_key_exists('request_type', $_GET) && array_key_exists('sender_login', $_GET) && array_key_exists('sender_password', $_GET)) {
        $link = Connection::open();
        $request_type = $_GET['request_type'];
        $sender = Account::from_login($_GET['sender_login'], $_GET['sender_password']);
        $login_err = $sender->login($link);
        if ($login_err == null) {
            switch ($request_type) {
                case 'add':
                    $new_order = Order::from_GET();
                    $add_err = $new_order->add($link, $sender);
                    if ($add_err == null) {
                        Response::send_ok($new_order);
                    } else {
                        Response::send_err($add_err);
                    }
                    break;
                case 'get':
                    $get_order = Order::from_uid($_GET['uid']);
                    $get_err = $get_order->get($link, $sender);
                    if ($get_err == null) {
                        Response::send_ok($get_order);
                    } else {
                        Response::send_err($get_err);
                    }
                    break;
                case 'delete':
                    $delete_order = Order::from_uid($_GET['uid']);
                    $delete_err = $delete_order->delete($link, $sender);
                    if ($delete_err == null) {
                        Response::send_ok($delete_order);
                    } else {
                        Response::send_err($delete_err);
                    }
                    break;
                case 'edit':
                    $edit_order = Order::from_GET();
                    $edit_err = $edit_order->edit($link, $sender);
                    if ($edit_err == null) {
                        Response::send_ok($edit_order);
                    } else {
                        Response::send_err($edit_err);
                    }
                    break;
                default:
                    Response::send_err(ErrList::$incorrect_request_type);
            }
        } else {
            Response::send_err($login_err);
        }
    } else {
        Response::send_err(ErrList::$missing_request_fields);
    }
?>