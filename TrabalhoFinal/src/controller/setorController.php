<?php
    require_once __DIR__ . "/../db.php";
    require_once __DIR__ . "/../model/Setor.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //header('Content-Type: application/json');
        $nome = $_POST['nome_setor'] ?? '';
        $s = new Setor($nome);
        $ok = $s->save($conn);
        echo json_encode(["status" => $ok ? "ok" : "erro"]);
    }
?>