<?php

    class UserService {
        private $userId;

        public function setUserId($userId) {
            $this->userId = $userId;
        }

        public function getUserId() {
            return $this->userId;
        }
    }


    $userService = new UserService();
?>