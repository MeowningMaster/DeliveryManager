<?php
    require_once('response.php');

    class Link {
        private static $host = 'localhost';
        private static $database = 'main'; //'u1113801_delivery_manager'
        private static $user = 'root'; //'u1113801'
        private static $password = ''; //'F0s7B4y8'

        public static function open() {
            $link = mysqli_connect(self::$host, self::$user, self::$password, self::$database);
            if ($link === false) {
                Response::send_err(ErrList::$cannot_link_database);
                exit();
            }

            $link->set_charset('utf8');
            return $link;
        }

        public static function close($link) {
            $link->close();
        }
    }
?>
