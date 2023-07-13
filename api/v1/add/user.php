<?php

    define('BASE_URL', '../../../');
    header('Content-Type: application/json; charset=utf-8');

    include_once BASE_URL . 'include/method.controller.php';
    $methodController->allowPost();

    include_once BASE_URL . 'include/jwt.controller.php';
    include_once BASE_URL . 'service/database.service.php';
    include_once BASE_URL . 'service/app.service.php';

    try {
        $body = json_decode(file_get_contents('php://input'), true);

        $conn = $databaseService->getConnection();

        $data = (object) $databaseService->prepareInsertInto($body);
        $sql = 'INSERT INTO utenti ('.$data->columns.') VALUES ('.$data->placeholders.')';
        $stm = $conn->prepare($sql)->execute($body);
        $databaseService->checkStmError($stm);

        $databaseService->close();

        $appService->dieWithCode(200, array(
            "status" => "OK",
            "message" => "Row correctly added"
        ));
        
    } catch (Exception $e) {
        $databaseService->close();
        $appService->dieWithCode(500, array(
            "status" => "KO",
            "message" => $e->getMessage()
        ));
    }

?>