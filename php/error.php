<?php
    class ErrList {
        public static function initiate() {
            ErrList::$cannot_link_database = Err::create(300,'Нет доступа к базе данных');
            ErrList::$missing_request_fields = Err::create(301,'В запросе не заполнены требуемые поля');
            ErrList::$incorrect_request_type = Err::create(302,'Неверный тип запроса');
            ErrList::$access_not_permitted = Err::create(303,'Нет прав для выполнения запроса');
            ErrList::$incorrect_login_or_password = Err::create(304, 'Неверный логин или пароль');

            ErrList::$incorrect_account = Err::create(311, 'Такого аккаунта не существует');
            ErrList::$cannot_access_accounts = Err::create(312,'Нет доступа к таблице пользователей или неправильный запрос');

            ErrList::$incorrect_order = Err::create(321, 'Такого заказа не существует');
            ErrList::$cannot_access_orders = Err::create(322,'Нет доступа к таблице заказов или неправильный запрос');
        }

        public static $cannot_link_database;
        public static $missing_request_fields;
        public static $incorrect_request_type;
        public static $access_not_permitted;
        public static $incorrect_login_or_password;

        public static $incorrect_account;
        public static $cannot_access_accounts;

        public static $incorrect_order;
        public static $cannot_access_orders;
    }
    ErrList::initiate();

    class Err {
        public $code;
        public $text;

        public static function create($code, $text) {
            $err = new Err();
            $err->code = $code;
            $err->text = $text;
            return $err;
        }
    }
?>