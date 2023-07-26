<?php

    define('BASE_URL', '../../../../');
    header('Content-Type: application/json; charset=utf-8');

    include_once BASE_URL . 'include/method.controller.php';
    $methodController->allowGet();

    include_once BASE_URL . 'include/jwt.controller.php';
    include_once BASE_URL . 'service/database.service.php';
    include_once BASE_URL . 'service/app.service.php';

    try {
        $conn = $databaseService->getConnection();
        $stm = $conn->query('SELECT * FROM ruoli');
        $databaseService->checkStmError($stm);
        $rows = $stm->fetchAll(PDO::FETCH_ASSOC);


        $databaseService->close();

        $appService->dieWithCode(200, array(
            "status" => "OK",
            "data" => $rows
        ));

    } catch (Exception $e) {
        $databaseService->close();
        $appService->dieWithCode(500, array(
            "status" => "KO",
            "message" => $e->getMessage()
        ));
    }

?>