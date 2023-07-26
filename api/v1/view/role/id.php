<?php

    define('BASE_URL', '../../../../');
    header('Content-Type: application/json; charset=utf-8');

    include_once BASE_URL . 'include/method.controller.php';
    $methodController->allowPost();

    include_once BASE_URL . 'include/jwt.controller.php';
    include_once BASE_URL . 'service/database.service.php';
    include_once BASE_URL . 'service/app.service.php';

    try {
        $body = json_decode(file_get_contents('php://input'), true);

        $conn = $databaseService->getConnection();
        $stm = $conn->query('SELECT * FROM ruoli WHERE id_ruolo = ' . $body["id"]);
        $databaseService->checkStmError($stm);
        $row = $stm->fetch(PDO::FETCH_ASSOC);

        $databaseService->close();

        $appService->dieWithCode(200, array(
            "status" => "OK",
            "data" => $row
        ));

    } catch (Exception $e) {
        $databaseService->close();
        $appService->dieWithCode(500, array(
            "status" => "KO",
            "message" => $e->getMessage()
        ));
    }

?>