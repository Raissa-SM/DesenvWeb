<?php
require_once __DIR__ . "/../db.php";
require_once __DIR__ . "/../model/Perguntas.php";

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? null;

    switch ($acao) {

        /* ========= LISTAR POR SETOR ========= */
        case "listar":
            $setor = $_POST['setor'];
            $res = Perguntas::listarPorSetor($conn, $setor);
            echo json_encode($res);
            break;


        /* ========= ADICIONAR ========= */
        case "adicionar":
            $setor = $_POST['setor'];
            $texto = $_POST['texto'];
            $numero = $_POST['numero'];
            $tipo = $_POST['tipo'];

            $p = new Perguntas($setor, $texto, $numero, $tipo, 1);
            $salvou = $p->save($conn);

            if ($salvou === "erro_tipo") {
                echo json_encode(["erro" => "Já existe pergunta de texto ativa neste setor."]);
            } elseif ($salvou === "erro_numero") {
                echo json_encode(["erro" => "O número da pergunta é inválido. Use apenas números inteiros maiores que zero."]);
            }else {
                echo json_encode(["status" => $salvou ? "ok" : "erro"]);
            }
            break;


        /* ========= EDITAR ========= */
        case "editar":
            $id = $_POST['id'];
            $setor = $_POST['setor'];
            $texto = $_POST['texto'];
            $numero = $_POST['numero'];
            $tipo = $_POST['tipo'];

            $ok = Perguntas::editar($conn, $id, $texto, $numero, $tipo, $setor);

            if ($ok === "erro_tipo") {
                echo json_encode(["erro" => "Já existe pergunta de texto ativa neste setor."]);
            } else {
                echo json_encode(["status" => $ok ? "ok" : "erro"]);
            }
            break;


        /* ========= DESATIVAR ========= */
        case "desativar":
            $id = $_POST['id'];

            $ok = Perguntas::desativar($conn, $id);
            echo json_encode(["status" => $ok ? "ok" : "erro"]);
            break;

        /* ========= STATUS ========= */
        case "status":
            $ret = Perguntas::alterarStatus($conn, $_POST['id'], $_POST['status']);

            if ($ret === "erro_tipo") {
                echo json_encode(["erro" => "Já existe uma pergunta de TEXTO ativa neste setor."]);
            } else {
                echo json_encode(["status" => $ret ? "ok" : "erro"]);
            }
            break;
        }
}
?>
