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
    function getDispositivoSetorById($conn, $id_dispositivo) {
        $sql = "SELECT d.nome_dispositivo, s.nome_setor
                FROM dispositivo d
                JOIN setor s ON d.id_setor = s.id_setor
                WHERE d.id_dispositivo = :id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([":id" => $id_dispositivo]);

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            return $resultado['nome_dispositivo'] . " - " . $resultado['nome_setor'];
        }

        return null; // caso não encontre
    }
?>

