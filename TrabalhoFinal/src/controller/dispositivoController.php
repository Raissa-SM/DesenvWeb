<?php
    require_once __DIR__ . "/../db.php";
    require_once __DIR__ . "/../model/Dispositivo.php";
    session_start();

    // === ROTAS DE REQUISIÇÃO ===
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {
        header('Content-Type: application/json');

        switch ($_POST['acao']) {
            // === DEFINIR DISPOSITIVO (sessão) ===
            case 'definirDispositivo':
                
                $id = $_POST['id_dispositivo'] ?? null;

                if (!$id) {
                    echo json_encode(["erro" => "Dispositivo não enviado"]);
                    exit;
                }

                $setor = Dispositivo::getSetorByDispositivo($conn, $id);

                $_SESSION['id_dispositivo'] = $id;
                $_SESSION['id_setor'] = $setor['id_setor'] ?? null;

                echo json_encode(["status" => "ok"]);
                break;

            // === ADICIONAR DISPOSITIVO ===
            case 'salvarDispositivo':
                $id_setor = $_POST['id_setor'] ?? null;
                $nome = $_POST['nome_dispositivo'] ?? '';

                $d = new Dispositivo($id_setor, $nome);
                
                $ok = $d->save($conn);
                echo json_encode(["status" => $ok ? "ok" : "erro"]);
                break;


        }
    }
?>