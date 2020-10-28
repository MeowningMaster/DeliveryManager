<?php
    require_once(__DIR__.'/connection.php');
    require_once(__DIR__.'/data/account.php');
    require_once(__DIR__.'/data/order.php');

    echo '<h1>Link</h1>';
    $link = Connection::open();
    var_dump($link);

    echo '<h1>Login</h1>';
    $admin = Account::from_login('admin', '%pvx6+;4vz6pUc4+');
    $admin->login($link);
    var_dump($admin);

    echo '<h1>Account</h1>';

    $account = Account::from_array([
        'type' => '2',
        'login' => 'hello_world',
        'password' => 'password',
        'name' => '3',
        'status' => '4',
        'phone_number' => '5',
        'telegram_id' => '6'
    ]);
    
    $err = $account->add($link, $admin);
    if ($err != null) {
        var_dump($err);
    } else {
        var_dump($account);
    }

    echo '<hr>';

    $old = clone $account;
    $account->type = '3';
    $err = $account->edit($link, $admin, $old);
    if ($err != null) {
        var_dump($err);
    } else {
        var_dump($account);
    }

    echo '<hr>';

    $err = $account->get($link, $admin);
    if ($err != null) {
        var_dump($err);
    } else {
        var_dump($account);
    }

    echo '<hr>';

    $err = $account->delete($link, $admin);
    if ($err != null) {
        var_dump($err);
    } else {
        var_dump($account);
    }

    echo '<h1>Order</h1>';
    
    $order = Order::from_array([
        'status' => 'Выполнен',
        'client' => 'cl',
        'contacts' => 'cont',
        'city' => 'cit',
        'address' => 'addr',
        'date' => '2020-10-14',
        'time' => '18:00:00',
        'cost' => '6000',
        'details' => 'det',
        'operator_uid' => '6',
        'courier_uid' => '8'
    ]);

    $err = $order->add($link, $admin);
    if ($err != null) {
        var_dump($err);
    } else {
        var_dump($order);
    }
    
    echo '<hr>';
    
    $old = clone $order;
    $order->status = 'Незавершен';
    $err = $order->edit($link, $admin);
    if ($err != null) {
        var_dump($err);
    } else {
        var_dump($order);
    }
    
    echo '<hr>';
    
    $err = $order->get($link, $admin);
    if ($err != null) {
        var_dump($err);
    } else {
        var_dump($order);
    }
    
    echo '<hr>';
    
    $err = $order->delete($link, $admin);
    if ($err != null) {
        var_dump($err);
    } else {
        var_dump($order);
    }
?>