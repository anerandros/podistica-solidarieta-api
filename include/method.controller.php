<?php

    class MethodController {
        public function allowPost() {
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                http_response_code(400);
                echo json_encode(array(
                    "status" => "KO",
                    "message" => "Method not allowed"
                ));
                exit();
            }
        }

        public function allowGet() {
            if ($_SERVER['REQUEST_METHOD'] != 'GET') {
                http_response_code(400);
                echo json_encode(array(
                    "status" => "KO",
                    "message" => "Method not allowed"
                ));
                exit();
            }
        }

        public function allowPut() {
            if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
                http_response_code(400);
                echo json_encode(array(
                    "status" => "KO",
                    "message" => "Method not allowed"
                ));
                exit();
            }
        }

        public function allowMixed() {
            
        }
    }

    $methodController = new MethodController();

?>