<?php
require_once(__DIR__.'/../response.php');
    require_once(__DIR__.'/data.php');

    class Account extends Data {
        public $uid;
        public $type;
        public $login;
        public $password;
        public $name;
        public $status;
        public $phone_number;
        public $telegram_id;

        public static function from_login($login, $password) {
            $account = new Account();
            $account->login = $login;
            $account->password = $password;
            return $account;
        }

        public function login($link) {
            $select = $this->to_sql_keys(null, ['login', 'password']);
            $sql = "SELECT $select FROM accounts WHERE login = :login AND password = :password";
            $sth = $link->prepare($sql);
            $this->bind_sql($sth, ['login', 'password']);
            if ($sth->execute()) {
                $row = $sth->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    $this->parse_array($row);
                    return null;
                } else {
                    return ErrList::$incorrect_login_or_password;
                }
            } else {
                return ErrList::$cannot_access_accounts;
            }
        }
        public function get($link, $sender) {
            $select = $this->to_sql_keys(null, ['uid']);
            $sql = "SELECT $select FROM accounts WHERE `uid` = :uid";
            $sth = $link->prepare($sql);
            $this->bind_sql($sth, ['uid']);
            if ($sth->execute()) {
                $row = $sth->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    $this->parse_array($row);
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
            if (($sender->type <= 2) && ($sender->type < $this->type)) {
                $into = $this->to_sql_keys(null, ['uid']);
                $placeholders = $this->to_sql_keys(null, ['uid'], Data::$TYPE_PLACEHOLDERS);
                $sql = "INSERT INTO accounts ($into) VALUES ($placeholders)";
                $sth = $link->prepare($sql);
                $this->bind_sql($sth, null, ['uid']);
                if ($sth->execute()) {
                    $this->uid = $link->lastInsertId();
                    return null;
                } else {
                    return ErrList::$cannot_access_accounts;
                }
            } else {
                return ErrList::$access_not_permitted;
            }
        }
        public function delete($link, $sender) {
            if (($sender->type <= 2) && ($sender->type < $this->type)) {
                $sql = 'DELETE FROM accounts WHERE `uid` = :uid';
                $sth = $link->prepare($sql);
                $this->bind_sql($sth, ['uid']);
                if ($sth->execute()) {
                     return null;
                } else {
                    return ErrList::$cannot_access_accounts;
                }
            } else {
                return ErrList::$access_not_permitted;
            }
        }
        public function edit($link, $sender, $old) {
            if (($sender->type <= 2) && ($sender->type < $this->type) && ($sender->type < $old->type)) {
                $set = $this->to_sql_keys(null, [], Data::$TYPE_BOTH);
                $sql = "UPDATE accounts SET $set WHERE `uid` = :uid";
                $sth = $link->prepare($sql);
                $this->bind_sql($sth);
                if ($sth->execute()) {
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