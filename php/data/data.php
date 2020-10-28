<?php
    class Data {
        public $uid;

        public static function from_uid($uid) {
            $data = new static();
            $data->uid = $uid;
            return $data;
        }
        public static function from_array($array) {
            $data = new static();
            $data->parse_array($array);
            return $data;
        }
        public function parse_array($array) {
            $vars = get_object_vars($this);
            foreach ($vars as $key => $value) {
                if (array_key_exists($key, $array)) {
                    $this->$key = $array[$key];
                }
            }
        }
        public static function from_GET() {
            return static::from_array($_GET);
        }

        public static $TYPE_BOTH = 1;
        public static $TYPE_FIELDS = 2;
        public static $TYPE_PLACEHOLDERS = 3;

        public function get_keys() {
            return array_keys(get_object_vars($this));
        }
        public function to_sql_keys($keys = null, $exclude = [], $type = 2) {
            if ($keys == null) {
                $keys = $this->get_keys();
            }

            $sql = '';
            foreach ($keys as $key) {
                if (!in_array($key, $exclude)) {
                    switch ($type) {
                        case self::$TYPE_BOTH:
                            $sql .= "`$key` = :$key, ";
                            break;
                        case self::$TYPE_FIELDS:
                            $sql .= "`$key`, ";
                            break;
                        case self::$TYPE_PLACEHOLDERS:
                            $sql .= ":$key, ";
                            break;
                    }
                }
            }
            $sql = rtrim($sql, ', ');
            return $sql;
        }
        public function bind_sql($sth, $keys = null, $exclude = []) {
            if ($keys == null) {
                $keys = $this->get_keys();
            }

            foreach ($keys as $key) {
                if (!in_array($key, $exclude)) {
                    $sth->bindValue(":$key", $this->$key, PDO::PARAM_STR);
                }
            }
        }
    }
?>