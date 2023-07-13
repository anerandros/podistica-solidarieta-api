<?php

    class AuthService {
        private $userId;

        public function setUserId($userId) {
            $this->userId = $userId;
        }

        public function getUserId() {
            return $this->userId;
        }
    }


    $authService = new AuthService();
?>