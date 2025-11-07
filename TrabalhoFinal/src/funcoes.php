<?php
    require_once "db.php";

    function getPerguntasDb($conn) {
        $sql = "SELECT id_pergunta, texto_pergunta, tipo_pergunta 
                FROM pergunta 
                WHERE status_pergunta = '1' 
                ORDER BY numero_pergunta";
        $stmt = $conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

            
    //function getRespostasDb($conn) {
    //     $sql = "SELECT numero_pergunta, texto_pergunta, tipo_pergunta 
    //             FROM pergunta 
    //             WHERE status_pergunta = '1' 
    //             ORDER BY 1";
    //     $stmt = $conn->query($sql);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
?>

