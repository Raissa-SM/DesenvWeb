<?php
    require_once __DIR__ . "/../db.php";
    require_once __DIR__ . "/../model/Dispositivo.php";
    require_once __DIR__ . "/../model/Setor.php";
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

            /* === LISTAR TODOS === */
            case "listar":
                echo json_encode(Dispositivo::listar($conn));
                break;

            /* === ADICIONAR === */
            case "adicionar":
                $nome  = trim($_POST["nome"]);
                $setor = $_POST["setor"];

                $d = new Dispositivo($setor, $nome);
                $ok = $d->save($conn);

                echo json_encode(["status" => $ok]);
                break;

            /* === EDITAR === */
            case "editar":
                $id    = $_POST["id"];
                $nome  = trim($_POST["nome"]);
                $setor = $_POST["setor"];

                $ok = Dispositivo::atualizar($conn, $id, $nome, $setor);
                echo json_encode(["status" => $ok]);
                break;

            /* === ATIVAR / DESATIVAR === */
            case "status":
                $id = $_POST["id"];
                $status = $_POST["status"];
                $ok = Dispositivo::alterarStatus($conn, $id, $status);
                echo json_encode(["status" => $ok]);
                break;

            /* === LISTAR SETORES (para o SELECT) === */
            case "listarSetores":
                echo json_encode(Setor::listar($conn));
                break;

            default:
                echo json_encode(["erro" => "Ação inválida"]);
        }
    }
?>