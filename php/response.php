<?php
    mb_internal_encoding("UTF-8");
    require_once (__DIR__.'/error.php');

    class Response {
        public static function send_ok($data) {
            $response = new Response_ok();
            $response->status = 200;
            $response->data = $data;
            echo json_encode($response);
        }

        public static function send_err($err) {
            $response = new Response_err();
            $response->status = $err->code;
            $response->err_text = $err->text;
            echo json_encode($response);
        }
    }

    class Response_ok {
        public $status;
        public $data;
    }

    class Response_err {
        public $status;
        public $err_text;
    }
?>