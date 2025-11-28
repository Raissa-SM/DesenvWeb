<?php
    require_once __DIR__ . "/../db.php";
    require_once __DIR__ . "/../model/Setor.php";

    $acao = $_POST["acao"] ?? null;

    switch ($acao) {

        case "listar":
            echo json_encode(Setor::listar($conn));
            break;

        case "adicionar":
            $nome = trim($_POST["nome"]);
            $setor = new Setor($nome);
            $ok = $setor->save($conn);
            echo json_encode(["status" => $ok]);
            break;

        case "editar":
            $id = $_POST["id"];
            $nome = trim($_POST["nome"]);
            $ok = Setor::atualizar($conn, $id, $nome);
            echo json_encode(["status" => $ok]);
            break;

        case "status":
            $id = $_POST["id"];
            $novoStatus = $_POST["status"];
            $ok = Setor::alterarStatus($conn, $id, $novoStatus);
            echo json_encode(["status" => $ok]);
            break;

        default:
            echo json_encode(["erro" => "Ação inválida"]);
    }
?>
