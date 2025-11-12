<?php
    require_once "../config.php";
    require_once "model/perguntas.php";

    //Conexão com o banco de dados
    try {
        $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Erro ao conectar ao banco: " . $e->getMessage();
        exit;
    }

    // Funções de banco de dados
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
                ':texto'  => $pergunta -> getTexto(),
                ':numero' => $pergunta -> getNumero(),
                ':tipo'   => $pergunta -> getTipo()
            ]);
        } catch (PDOException $e) {
            echo "Erro ao inserir pergunta: " . $e->getMessage();
        }
    }
?>