<?php
    class OrderFilter {
        public $fields = [];

        public static function from_GET() {
            return self::from_array($_GET);
        }

        public static function from_array($array) {
            $order_filter = new OrderFilter();
            foreach (Order::$fields as $field) {
                if (array_key_exists($field, $array)) {
                    $order_filter->fields[$field] = $array[$field];
                }
            }
            return $order_filter;
        }
    }
?>