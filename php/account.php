<?php
    require_once('response.php');

    class Account {
        public $login;
        public $password;

        public $uid;
        public $type;
        public $name;
        public $status;
        public $phone_number;
        public $telegram_id;

        private static $fields = ['uid', 'type', 'login', 'password', 'name', 'status', 'phone_number', 'telegram_id'];

        public static function from_uid($uid) {
            $account = new Account();
            $account->uid = $uid;
            return $account;
        }

        public static function from_login($login, $password) {
            $account = new Account();
            $account->login = $login;
            $account->password = $password;
            return $account;
        }

        public static function from_array($array) {
            $account = new Account();
            $account->parse_array($array);
            return $account;
        }

        public static function from_GET() {
            return Account::from_array($_GET);
        }

        public function parse_array($array) {
            foreach (self::$fields as $field) {
                if (array_key_exists($field, $array)) {
                    $this->$field = $array[$field];
                }
            }
        }

        public function login($link) {
            $query = $link->prepare('Select `uid`, `type`, `name`, `status`, `phone_number`, `telegram_id` FROM accounts WHERE login = ? AND password = ?');
            $query->bind_param('ss', $this->login, $this->password);
            if ($query->execute()) {
                $result = $query->get_result();
                if ($result->num_rows == 1) {
                    $this->parse_array($result->fetch_assoc());
                    return null;
                } else {
                    return ErrList::$incorrect_login_or_password;
                }
            } else {
                return ErrList::$cannot_access_accounts;
            }
        }

        public function get($link, $sender) {
            $query = $link->prepare('SELECT * FROM accounts WHERE `uid` = ?');
            $query->bind_param('s', $this->uid);
            if ($query->execute()) {
                $result = $query->get_result();
                if ($result->num_rows == 1) {
                    $this->parse_array($result->fetch_assoc());
                    if ($sender->type < $this->type) {
                        if ($sender->type == 3) {
                            $this->login = '';
                            $this->password = '';
                        }
                        return null;
                    } else {
                        return ErrList::$access_not_permitted;
                    }
                } else {
                    return ErrList::$incorrect_account;
                }
            } else {
                return ErrList::$cannot_access_accounts;
            }
        }

        public function add($link, $sender) {
            if (($sender->type <= 2) && ($sender->type < $this->type)) { //if admin or coordinator AND have permission
                $query = $link->prepare('INSERT INTO accounts (`type`, `login`, `password`, `name`, `status`, `phone_number`, `telegram_id`) VALUES (?, ?, ?, ?, ?, ?, ?)');
                $query->bind_param('sssssss', $this->type, $this->login, $this->password, $this->name, $this->status, $this->phone_number, $this->telegram_id);
                if ($query->execute()) {
                    $this->uid = $query->insert_id;
                    return null;
                } else {
                    return ErrList::$cannot_access_accounts;
                }
            } else {
                return ErrList::$access_not_permitted;
            }
        }

        public function delete($link, $sender) {
            if (($sender->type <= 2) && ($sender->type < $this->type)) { //if admin or coordinator AND have permission
                $query = $link->prepare('DELETE FROM accounts WHERE `uid` = ?');
                $query->bind_param('s', $this->uid);
                if ($query->execute()) {
                     return null;
                } else {
                    return ErrList::$cannot_access_accounts;
                }
            } else {
                return ErrList::$access_not_permitted;
            }
        }

        public function edit($link, $sender, $old) {
            if (($sender->type <= 2) && ($sender->type < $this->type) && ($sender->type < $old->type)) { //if admin or coordinator AND have permission
                $query = $link->prepare('UPDATE accounts SET `type` = ?, `login` = ?, `password` = ?, `name` = ?, `status` = ?, `phone_number` = ?, `telegram_id` = ? WHERE `uid` = ?');
                $query->bind_param('ssssssss', $this->type, $this->login, $this->password, $this->name, $this->status, $this->phone_number, $this->telegram_id, $this->uid);
                if ($query->execute()) {
                    return null;
                } else {
                    return ErrList::$cannot_access_accounts;
                }
            } else {
                return ErrList::$access_not_permitted;
            }
        }
    }
?>