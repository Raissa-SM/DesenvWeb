<?php
    function getDispositivosPorSetor($conn) {
        $sql = "SELECT s.id_setor, s.nome_setor, d.id_dispositivo, d.nome_dispositivo
                FROM setor s
                JOIN dispositivo d ON d.id_setor = s.id_setor
                WHERE s.status_setor = '1' AND d.status_dispositivo = '1'
                ORDER BY s.nome_setor, d.nome_dispositivo";

        $stmt = $conn->query($sql);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $setores = [];
        foreach ($resultados as $r) {
            $setores[$r['nome_setor']][] = $r;
        }
        return $setores;
    }
?>

