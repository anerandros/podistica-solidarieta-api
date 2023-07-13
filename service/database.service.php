<?php

    class DatabaseService {
        private $db_host = "localhost";
        private $db_user = "root";
        private $db_password = "";
        private $db_name = "podistica";
        private $connection;

        public function getConnection() {
            $this->connection = null;
            try {
                $this->connection = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name, $this->db_user, $this->db_password);
            } catch(PDOException $exception){
                http_response_code(500); 
                echo json_encode(array( 
                    "status" => "KO",
                    "message" => "Database connection failed"
                ));
                exit();
            }

            return $this->connection;
        }

        public function close() {
            $this->connection = null;
        }

        public function checkStmError($stm) {
            if (!$stm) {
                http_response_code(500);
                echo json_encode(array(
                    "status" => "KO",
                    "message" => "Error statement"
                ));
                exit();
            }
        }

        public function prepareInsertInto($array) {
            $columns = '';
            $placeholders = '';
            $index = 0;
            foreach($array as $key => $value) { 
                if ($index < count($array) - 1) {
                    $columns .= $key . ", ";
                    $placeholders .= ":".$key.", ";
                } else {
                    $columns .= $key;
                    $placeholders .= ":".$key;
                }
                $index++;
            }

            return array(
                "columns" => $columns,
                "placeholders" => $placeholders
            );
        }

        public function prepareUpdate($array) {
            $columns = '';
            $index = 0;
            foreach($array as $key => $value) { 
                if ($index < count($array) - 1) {
                    $columns .= $key . " = :". $key .", ";
                } else {
                    $columns .= $key . " = :". $key;
                }
                $index++;
            }

            return array(
                "columns" => $columns,
            );
        }

    }

    $databaseService = new DatabaseService();

?>