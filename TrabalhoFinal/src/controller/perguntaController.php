<?php
    require_once __DIR__ . "/../db.php";
    require_once __DIR__ . "/../model/Perguntas.php";

    // === ROTAS DE REQUISIÇÃO ===
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //header('Content-Type: application/json');
 
        $texto = $_POST['texto'] ?? '';
        $num = $_POST['numero'] ?? null;
        $tipo = $_POST['tipo'] ?? 1;
        $p = new Perguntas($texto, $num, $tipo);
        $ok = $p->save($conn);
        echo json_encode(["status" => $ok ? "ok" : "erro"]);
    }
?>