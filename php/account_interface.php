<?php
    require_once('response.php');
    require_once('link.php');
    require_once('account.php');

    if (array_key_exists('request_type', $_GET) && array_key_exists('sender_login', $_GET) && array_key_exists('sender_password', $_GET)) {
        $link = Link::open();
        $request_type = $_GET['request_type'];
        $sender = Account::from_login($_GET['sender_login'], $_GET['sender_password']);
        $login_err = $sender->login($link);
        if ($login_err == null) {
            switch ($request_type) {
                case 'login':
                    Response::send_ok($sender);
                    break;
                case 'add':
                    $new_account = Account::from_GET();
                    $add_err = $new_account->add($link, $sender);
                    if ($add_err == null) {
                        Response::send_ok($new_account);
                    } else {
                        Response::send_err($add_err);
                    }
                    break;
                case 'get':
                    $get_account = Account::from_uid($_GET['uid']);
                    $get_err = $get_account->get($link, $sender);
                    if ($get_err == null) {
                        Response::send_ok($get_account);
                    } else {
                        Response::send_err($get_err);
                    }
                    break;
                case 'delete':
                    $delete_account = Account::from_uid($_GET['uid']);
                    $get_err = $delete_account->get($link, $sender);
                    if ($get_err == null) {
                        $delete_err = $delete_account->delete($link, $sender);
                        if ($delete_err == null) {
                            Response::send_ok($delete_account);
                        } else {
                            Response::send_err($delete_err);
                        }
                    } else {
                        Response::send_err($get_err);
                    }
                    break;
                case 'edit':
                    $edit_account = Account::from_GET();
                    $old_account = Account::from_uid($edit_account->uid);
                    $get_err = $old_account->get($link, $sender);
                    if ($get_err == null) {
                        $edit_err = $edit_account->edit($link, $sender, $old);
                        if ($edit_err == null) {
                            Response::send_ok($edit_account);
                        } else {
                            Response::send_err($edit_err);
                        }
                    } else {
                        Response::send_err($get_err);
                    }
                    break;
                default:
                    Response::send_err(ErrList::$incorrect_request_type);
            }
        } else {
            Response::send_err($login_err);
        }
        Link::close($link);
    } else {
        Response::send_err(ErrList::$missing_request_fields);
    }
?>