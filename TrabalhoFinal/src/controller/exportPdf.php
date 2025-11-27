<?php
require_once "../db.php";
require_once "../lib/fpdf.php";

// Consulta dados
$stmt = $conn->query("
    SELECT 
        to_char(a.data_hora, 'DD/MM/YYYY HH24:MI') as data,
        d.nome_dispositivo,
        s.nome_setor,
        r.nota,
        a.feedback_texto
    FROM avaliacao a
    JOIN dispositivo d ON a.id_dispositivo = d.id_dispositivo
    JOIN setor s ON d.id_setor = s.id_setor
    JOIN resposta r ON r.id_avaliacao = a.id_avaliacao
    ORDER BY a.data_hora DESC
");

$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Inicia PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, "Relatório de Avaliações", 0, 1, 'C');
$pdf->Ln(4);

$pdf->SetFont('Arial', '', 12);

foreach ($dados as $row) {

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0, 8, "Data: " . $row['data'], 0, 1);

    $pdf->SetFont('Arial','',12);
    $pdf->Cell(0, 7, "Dispositivo: " . $row['nome_dispositivo'], 0, 1);
    $pdf->Cell(0, 7, "Setor: " . $row['nome_setor'], 0, 1);
    $pdf->Cell(0, 7, "Nota: " . $row['nota'], 0, 1);

    if (!empty(trim($row['feedback_texto']))) {
        $pdf->MultiCell(0, 7, "Comentário: " . $row['feedback_texto']);
    } else {
        $pdf->Cell(0, 7, "Comentário: (nenhum)", 0, 1);
    }

    $pdf->Ln(3);
    $pdf->Cell(0, 0, str_repeat("-", 95), 0, 1);
    $pdf->Ln(4);
}

// Gera PDF
$pdf->Output("I", "relatorio.pdf"); // I = abre no navegador
exit;
?>