<?php
    require_once(__DIR__.'/response.php');

    class Connection {
        private static $host = 'localhost';
        private static $database = 'main'; //'u1113801_delivery_manager'
        private static $user = 'root'; //'u1113801'
        private static $password = ''; //'F0s7B4y8'

        public static function open() {
            try {
                $dns = 'mysql:host='.Connection::$host.';dbname='.Connection::$database.';charset=utf8';
                return new PDO($dns, Connection::$user, Connection::$password);
            } catch (PDOException $e) {
                Response::send_err(ErrList::$cannot_link_database);
                exit();
            }
        }
    }
?>
