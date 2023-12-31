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
        $stm = $conn->query('SELECT * FROM ruoli_funzionalita AS rf INNER JOIN ruoli as r ON rf.id_ruolo = r.id_ruolo INNER JOIN funzionalita as f ON rf.id_funzionalita = f.id_funzionalita WHERE rf.id_ruolo = ' . $body["id"]);
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