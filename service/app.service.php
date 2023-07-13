<?php

    class AppService {

        public function dieWithCode($code, $json) {
            http_response_code($code);
            exit(json_encode($json));
        }

    }

    $appService = new AppService();

?>