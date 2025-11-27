<?php
require_once "../db.php";

header('Content-disposition: attachment; filename=relatorio.xlsx');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");

$stmt = $conn->query("
    SELECT a.data_hora, d.nome_dispositivo, s.nome_setor, r.nota, a.feedback_texto
    FROM avaliacao a
    JOIN dispositivo d ON a.id_dispositivo = d.id_dispositivo
    JOIN setor s ON d.id_setor = s.id_setor
    JOIN resposta r ON r.id_avaliacao = a.id_avaliacao
    ORDER BY a.data_hora DESC
");

$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gera Excel simples
$xml = '<?xml version="1.0"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet">';

$xml .= "<Worksheet ss:Name='Relatorio'><Table>";

if ($dados) {
    // Cabeçalho
    $xml .= "<Row>";
    foreach (array_keys($dados[0]) as $col) {
        $xml .= "<Cell><Data ss:Type='String'>$col</Data></Cell>";
    }
    $xml .= "</Row>";

    // Linhas
    foreach ($dados as $row) {
        $xml .= "<Row>";
        foreach ($row as $cell) {
            $xml .= "<Cell><Data ss:Type='String'>" . htmlspecialchars($cell) . "</Data></Cell>";
        }
        $xml .= "</Row>";
    }
}

$xml .= "</Table></Worksheet></Workbook>";

echo $xml;
exit;
?>