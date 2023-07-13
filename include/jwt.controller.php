<?php

    include_once BASE_URL . 'service/jwt.service.php';
    include_once BASE_URL . 'service/auth.service.php';
    
    if (isSet($_SERVER['HTTP_X_AUTH_TOKEN'])) {
        $jwt = $_SERVER['HTTP_X_AUTH_TOKEN']; 

        if ($jwt) {
            try {
                $decoded = $jwtService->decode($jwt);
                $decodedJWT = (array) $decoded;
                $date = date("Y-m-d H:i:s", $decodedJWT["exp"]);
                $expirationDate = strtotime($date);
                $now = time();

                // if ($now - $expirationDate <= $jwtService->expirationTreshold) {
                //     $authService->setUserId($decodedJWT["data"]->userId);
                // } else {
                //     http_response_code(401); 
                //     echo json_encode(array( 
                //         "status" => "KO",
                //         "message" => "JWT token expired"
                //     ));
                //     exit();
                // }

                $authService->setUserId($decodedJWT["data"]->userId);

            } catch (Exception $e) { 
                http_response_code(401); 
                echo json_encode(array( 
                    "status" => "KO",
                    "message" => "JWT token not verified",
                    "catched" => $e->getMessage()
                ));
                exit();
            } 
        } else {
            http_response_code(401);
            echo json_encode(array(
                "status" => "KO",
                "message" => "JWT token required"
            ));
            exit();
        }
    } else {
        http_response_code(401);
        echo json_encode(array(
            "status" => "KO",
            "message" => "Authorization header required"
        ));
        exit();
    }

?>