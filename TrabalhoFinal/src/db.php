<?php
    require_once "../config.php";
    require_once "model/Avaliacao.php";
    require_once "model/Perguntas.php";
    require_once "model/Respostas.php";
    require_once "model/Dispositivo.php";
    require_once "model/Setor.php";
    require_once "funcoes.php";

    // === CONEXÃO COM O BANCO ===
    try {
        $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo json_encode(["erro" => "Erro ao conectar: " . $e->getMessage()]);
        exit;
    }

    // === ROTAS DE REQUISIÇÃO ===
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {
        header('Content-Type: application/json');

        switch ($_POST['acao']) {

            // === AVALIAÇÃO ===
            case 'salvarAvaliacao':
                session_start();
                $id_dispositivo = $_SESSION['id_dispositivo'] ?? null;
                $feedback = $_POST['feedback'] ?? '';

                if (!$id_dispositivo) {
                    echo json_encode(["erro" => "Dispositivo não definido."]);
                    exit;
                }

                $avaliacao = new Avaliacao($id_dispositivo, $feedback);
                $idAvaliacao = $avaliacao->save($conn);

                if ($idAvaliacao) {
                    // Salva respostas
                    $respostas = $_POST['respostas'] ?? [];
                    foreach ($respostas as $idPergunta => $nota) {
                        $r = new Respostas($idPergunta, $idAvaliacao, $nota);
                        $r->save($conn);
                    }
                    echo json_encode(["status" => "ok"]);
                } else {
                    echo json_encode(["erro" => "Erro ao salvar avaliação"]);
                }
                break;

            // === DEFINIR DISPOSITIVO (sessão) ===
            case 'definirDispositivo':
                session_start();
                $id_dispositivo = $_POST['id_dispositivo'] ?? null;
                if (!$id_dispositivo) {
                    echo json_encode(["erro" => "Dispositivo não enviado"]);
                    exit;
                }

                $sql = "SELECT id_setor FROM dispositivo WHERE id_dispositivo = :id";
                $stmt = $conn->prepare($sql);
                $stmt->execute([':id' => $id_dispositivo]);
                $setor = $stmt->fetch(PDO::FETCH_ASSOC);

                $_SESSION['id_dispositivo'] = $id_dispositivo;
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

            // === ADICIONAR SETOR ===
            case 'salvarSetor':
                $nome = $_POST['nome_setor'] ?? '';
                $s = new Setor($nome);
                $ok = $s->save($conn);
                echo json_encode(["status" => $ok ? "ok" : "erro"]);
                break;

            // === ADICIONAR PERGUNTA ===
            case 'salvarPergunta':
                $texto = $_POST['texto'] ?? '';
                $num = $_POST['numero'] ?? null;
                $tipo = $_POST['tipo'] ?? 1;
                $p = new Perguntas($texto, $num, $tipo);
                $ok = $p->save($conn);
                echo json_encode(["status" => $ok ? "ok" : "erro"]);
                break;
        }
    }
?>