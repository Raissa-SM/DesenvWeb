<?php
    require_once '../model/Avaliacao.php';
    require_once '../model/Resposta.php';
    require_once '../db.php';

    function criarAvaliacaoComRespostas($post) {
        global $conn;

        // Sanitização
        $id_setor = filter_var($post['id_setor'] ?? null, FILTER_VALIDATE_INT);
        $id_dispositivo = filter_var($post['id_dispositivo'] ?? null, FILTER_VALIDATE_INT);
        $feedback = trim($post['feedback'] ?? '');

        $avaliacao = new Avaliacao($id_setor, $id_dispositivo, $feedback);

        try {
            $conn->beginTransaction();

            $idAval = $avaliacao->save($conn);
            if (!$idAval) throw new Exception('Não foi possível inserir avaliação.');

            // $post['respostas'] esperado como array: ['<id_pergunta>' => 'nota', ...]
            $respostasPost = $post['respostas'] ?? [];
            foreach ($respostasPost as $idPerg => $nota) {
                $idPerg = filter_var($idPerg, FILTER_VALIDATE_INT);
                $nota = filter_var($nota, FILTER_VALIDATE_INT);
                if ($idPerg === false || $nota === false) continue; // ou lançar erro

                $resposta = new Resposta($idPerg, $idAval, $nota);
                $ok = $resposta->save($conn);
                if (!$ok) throw new Exception("Erro ao salvar resposta da pergunta $idPerg");
            }

            $conn->commit();
            return $idAval;
        } catch (Exception $e) {
            $conn->rollBack();
            // logar $e->getMessage()
            return false;
        }
    }
?>