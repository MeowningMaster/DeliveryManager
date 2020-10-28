<?php
    require_once('account.php');

    $link = Link::open();
    $admin = Account::from_login('admin', '%pvx6+;4vz6pUc4+');
    $admin->login($link);

    /* add test
    $new_account = Account::from_array([
        'type' => '2',
        'login' => 'hello1',
        'password' => 'world',
        'name' => '3',
        'status' => '4',
        'phone_number' => '5',
        'telegram_id' => '6'
    ]);
    $err = $new_account->add($link, $admin);
    if ($err != null) {
        Response::send_err($err);
    } else {
        Response::send_ok($add_account);
    }
    */

    /* get test
    $get_account = Account::from_uid('5');
    $err = $get_account->get($link, $admin);
    if ($err != null) {
        Response::send_err($err);
    } else {
        Response::send_ok($get_account);
    }
    */
?>