<?php

    require BASE_URL . "vendor/autoload.php";
    use \Firebase\JWT\JWT;
    use \Firebase\JWT\Key;

    class JWTService {
        private $secretKey = "YOUR_SECRET_KEY";
        private $hashMethod = "HS256";

        public $expirationTreshold = 60*60*24;

        public function encode($dataToEncode) {
            $now = time();
            $oneDay = 60*60*24;
            $exp = $now + $oneDay;
            $token = array(
                "exp" => $exp,
                "data" => $dataToEncode
            );
            return JWT::encode($token, $this->secretKey, $this->hashMethod);
        }

        public function decode($jwt) {
            return JWT::decode($jwt, new Key($this->secretKey, $this->hashMethod));
        }
    }


    $jwtService = new JWTService();
?>