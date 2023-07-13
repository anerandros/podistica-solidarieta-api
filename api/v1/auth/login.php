<?php

    define('BASE_URL', '../../../');
    header('Content-Type: application/json; charset=utf-8');

    include_once BASE_URL . 'include/method.controller.php';
    $methodController->allowPost();

    include_once BASE_URL . 'service/database.service.php';
    include_once BASE_URL . 'service/jwt.service.php';
    include_once BASE_URL . 'service/app.service.php';

    try {
        $body = (object) json_decode(file_get_contents('php://input'), true);

        $conn = $databaseService->getConnection();
        $sql = "SELECT * FROM utenti WHERE username_utente = '" . $body->username . "' AND password_utente = '" . hash('sha256', $body->password) ."'";
        $stm = $conn->query($sql);
        $databaseService->checkStmError($stm);
        $row = $stm->fetch(PDO::FETCH_ASSOC);

        $databaseService->close();

        if ($row) {
            $token = $jwtService->encode(
                array(
                    "userId" => $row["id_utente"],
                    "roleId" => $row["id_ruolo"]
                )
            );

            $appService->dieWithCode(200, array(
                "status" => "OK",
                "token" => $token,
            ));
        } else {
            $appService->dieWithCode(401, array(
                "status" => "KO",
                "message" => "Username/password incorrect"
            ));
        }

    } catch (Exception $e) {
        $databaseService->close();
        $appService->dieWithCode(500, array(
            "status" => "KO",
            "message" => $e->getMessage()
        ));
    }

?>