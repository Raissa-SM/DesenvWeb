<?php
    require_once __DIR__ . "/../db.php";
    require_once __DIR__ . "/../model/Avaliacao.php";
    require_once __DIR__ . "/../model/Respostas.php";
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        //header('Content-Type: application/json');

        $idDispositivo = $_SESSION['id_dispositivo'] ?? null;
        $feedback = $_POST['feedback'] ?? '';

        if (!$idDispositivo) {
            echo json_encode(["erro" => "Dispositivo não definido."]);
            exit;
        }

        $avaliacao = new Avaliacao($idDispositivo, $feedback);
        $idAvaliacao = $avaliacao->save($conn);

        if (!$idAvaliacao) {
            echo json_encode(["erro" => "Erro ao salvar avaliação"]);
            exit;
        }

        foreach ($_POST['respostas'] as $idPergunta => $nota) {

            $nota = filter_var($nota, FILTER_VALIDATE_INT);

            if ($nota === false || $nota < 0 || $nota > 10) {
                echo json_encode(["erro" => "Nota inválida recebida no servidor."]);
                exit;
            }

            $r = new Respostas($idPergunta, $idAvaliacao, $nota);
            $r->save($conn);
        }

        echo json_encode(["status" => "ok"]);
    }
?>