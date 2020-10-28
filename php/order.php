<?php
    require_once('response.php');
    require_once('link.php');

    class Order {
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

        private static $fields = ['uid', 'status', 'client', 'contacts', 'city', 'address', 'date', 'time', 'cost', 'details', 'operator_uid', 'courier_uid'];

        public static function from_uid($uid) {
            $order = new Order();
            $order->uid = $uid;
            return $order;
        }

        public static function from_array($array) {
            $order = new Order();
            $order->parse_array($array);
            return $order;
        }

        public static function from_GET() {
            return Order::from_array($_GET);
        }

        public function parse_array($array) {
            foreach (self::$fields as $field) {
                if (array_key_exists($field, $array)) {
                    $this->$field = $array[$field];
                }
            }
        }

        public function get($link, $sender) {
            $query = $link->prepare('SELECT `uid`, `status`, `client`, `contacts`, `city`, `address`, DATE_FORMAT(`date`, "%m/%d/%Y") AS `date`, DATE_FORMAT(`time`, "%H:%i") AS `time`, `cost`, `details`, `operator_uid`, `courier_uid` FROM orders WHERE `uid` = ?');
            $query->bind_param('s', $this->uid);
            if ($query->execute()) {
                $result = $query->get_result();
                if ($result->num_rows == 1) {
                    $this->parse_array($result->fetch_assoc());
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
                $query = $link->prepare('INSERT INTO orders (`status`, `client`, `contacts`, `city`, `address`, `date`, `time`, `cost`, `details`, `operator_uid`, `courier_uid`) VALUES  (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
                $query->bind_param('sssssssssss', $this->status, $this->client, $this->contacts, $this->city, $this->address, $this->date, $this->time, $this->cost, $this->details, $this->operator_uid, $this->courier_uid);
                if ($query->execute()) {
                    $this->uid = $query->insert_id;
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
                $query= $link->prepare('DELETE FROM orders WHERE `uid` = ?');
                $query->bind_params('s', $this->uid);
                if ($query->execute()) {
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
                $query= $link->prepare('UPDATE orders SET `status` = ?, `client` = ?, `contacts` = ?, `city` = ?, `address` = ?, `date` = ?, `time` = ?, `cost` = ?, `details` = ?, `operator_uid` = ?, `courier_uid` = ? WHERE `uid` = ?');
                $query->bind_params('ssssssssssss', $this->status, $this->client, $this->contacts, $this->city, $this->address, $this->date, $this->time, $this->cost, $this->details, $this->operator_uid, $this->courier_uid, $this->uid);
                if ($query->execute()) {
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