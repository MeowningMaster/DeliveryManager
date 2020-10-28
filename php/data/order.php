<?php
    require_once(__DIR__.'/../response.php');
    require_once(__DIR__.'/data.php');
    require_once(__DIR__.'/filter/order_filter.php');

    class Order extends Data {
        public $uid;
        public $status;
        public $client;
        public $contacts;
        public $city;
        public $address;
        public $date;
        public $time;
        public $cost;
        public $details;
        public $operator_uid;
        public $courier_uid;

        public function get($link, $sender) {
            $select = $this->to_sql_keys(null, ['uid']);
            $sql = "SELECT $select FROM orders WHERE `uid` = :uid";
            $sth = $link->prepare($sql);
            $this->bind_sql($sth, ['uid']);
            if ($sth->execute()) {
                $row = $sth->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    $this->parse_array($row);
                    switch ($sender->type) {
                        case 3:
                            if ($this->operator_uid == $sender->uid) {
                                return null;
                            } else {
                                return ErrList::$access_not_permitted;
                            }
                        case 4:
                            if ($this->courier_uid == $sender->uid) {
                                return null;
                            } else {
                                return ErrList::$access_not_permitted;
                            }
                        default:
                            return null;
                    }
                } else {
                    return ErrList::$incorrect_order;
                }
            } else {
                return ErrList::$cannot_access_orders;
            }
        }
        public function add($link, $sender) {
            if (($sender->type <= 2) || (($sender->type == 3) && ($this->operator_uid == $sender->uid))) {
                $into = $this->to_sql_keys(null, ['uid']);
                $placeholders = $this->to_sql_keys(null, ['uid'], Data::$TYPE_PLACEHOLDERS);
                $sql = "INSERT INTO orders ($into) VALUES ($placeholders)";
                $sth = $link->prepare($sql);
                $this->bind_sql($sth, null, ['uid']);
                if ($sth->execute()) {
                    $this->uid = $link->lastInsertId();
                    return null;
                } else {
                    return ErrList::$cannot_access_orders;
                }
            } else {
                return ErrList::$access_not_permitted;
            }
        }
        public function delete($link, $sender) {
            if ($sender->type <= 2) {
                $sql = 'DELETE FROM orders WHERE `uid` = :uid';
                $sth= $link->prepare($sql);
                $this->bind_sql($sth, ['uid']);
                if ($sth->execute()) {
                    return null;
                } else {
                    return ErrList::$cannot_access_orders;
                }
            } else {
                return ErrList::$access_not_permitted;
            }
        }
        public function edit($link, $sender) {
            if ($sender->type <= 2) {
                $set = $this->to_sql_keys(null, [], Data::$TYPE_BOTH);
                $sql = "UPDATE orders SET $set WHERE `uid` = :uid";
                $sth = $link->prepare($sql);
                $this->bind_sql($sth);
                if ($sth->execute()) {
                    return null;
                } else {
                    return ErrList::$cannot_access_orders;
                }
            } else {
                return ErrList::$access_not_permitted;
            }
        }
    }
?>
