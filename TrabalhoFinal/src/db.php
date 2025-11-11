<?php
    require_once "../config.php";

    //Conexão com o banco de dados
    try {
        $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Erro ao conectar ao banco: " . $e->getMessage();
        exit;
    }

    // Funções de banco de dados

    function setAvaliacaoDb($avaliacao) {
        global $conn;
        try {
            $sql = "INSERT INTO avaliacao (id_setor, id_dispositivo, feedback_texto, data_hora)
                    VALUES (:setor, :dispositivo, :feedback, :data_hora)";

            $stmt = $conn->prepare($sql);

            $stmt->execute([
                ':setor'  => $avaliacao -> getId_setor,
                ':dispositivo' => $avaliacao -> getId_dispositivo,
                ':feedback'   => $avaliacao -> getFeedback_texto,
                ':data_hora'   => $avaliacao -> getData_hora
            ]);

            echo "Avaliação inserida com sucesso!";

        } catch (PDOException $e) {
            echo "Erro ao inserir avaliação: " . $e->getMessage();
        }
    }

    function getPerguntasDb() {
        global $conn;
        $sql = "SELECT id_pergunta, texto_pergunta, tipo_pergunta 
                FROM pergunta 
                WHERE status_pergunta = '1' 
                ORDER BY numero_pergunta";
        $stmt = $conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function setPerguntaDb($pergunta) {
        global $conn;
        try {
            $sql = "INSERT INTO pergunta (texto_pergunta, numero_pergunta, tipo_pergunta)
                    VALUES (:texto, :numero, :tipo)";

            $stmt = $conn->prepare($sql);

            $stmt->execute([
                ':texto'  => $pergunta -> getTexto,
                ':numero' => $pergunta -> getNumeronumero,
                ':tipo'   => $pergunta -> getTipo
            ]);

            echo "Pergunta inserida com sucesso!";

        } catch (PDOException $e) {
            echo "Erro ao inserir pergunta: " . $e->getMessage();
        }
    }
?>