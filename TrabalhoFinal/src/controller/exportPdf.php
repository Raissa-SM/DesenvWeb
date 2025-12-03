<?php
require_once "../db.php";
require_once "../lib/fpdf.php";

/* Conversão de UTF8 → ISO para evitar erros no PDF */
function t($str) {
    return utf8_decode($str);
}

/* ==========================
   RECEBE FILTROS POR GET
   ========================== */
$dataInicio  = $_GET["data_inicio"] ?? null;
$dataFim     = $_GET["data_fim"] ?? null;
$setor       = $_GET["setor"] ?? null;
$dispositivo = $_GET["dispositivo"] ?? null;

/* ==========================
   QUERY BASE
   ========================== */
$sql = "
    SELECT 
        a.id_avaliacao,
        to_char(a.data_hora, 'DD/MM/YYYY HH24:MI') AS data,
        d.nome_dispositivo,
        s.nome_setor,
        r.nota,
        p.numero_pergunta,
        p.texto_pergunta,
        a.feedback_texto
    FROM avaliacao a
    JOIN dispositivo d ON a.id_dispositivo = d.id_dispositivo
    JOIN setor s ON d.id_setor = s.id_setor
    JOIN resposta r ON r.id_avaliacao = a.id_avaliacao
    JOIN pergunta p ON p.id_pergunta = r.id_pergunta
    WHERE 1=1
";

$params = [];

/* ==========================
   FILTROS DINÂMICOS
   ========================== */
if ($dataInicio) {
    $sql .= " AND a.data_hora::date >= :dataInicio";
    $params[":dataInicio"] = $dataInicio;
}
if ($dataFim) {
    $sql .= " AND a.data_hora::date <= :dataFim";
    $params[":dataFim"] = $dataFim;
}
if ($setor) {
    $sql .= " AND s.id_setor = :setor";
    $params[":setor"] = $setor;
}
if ($dispositivo) {
    $sql .= " AND d.id_dispositivo = :dispositivo";
    $params[":dispositivo"] = $dispositivo;
}

$sql .= " ORDER BY a.data_hora DESC, p.numero_pergunta";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ==========================
   AGRUPAR POR AVALIAÇÃO
   ========================== */
$rel = [];

foreach ($dados as $d) {
    $id = $d["id_avaliacao"];

    if (!isset($rel[$id])) {
        $rel[$id] = [
            "data"        => $d["data"],
            "dispositivo" => $d["nome_dispositivo"],
            "setor"       => $d["nome_setor"],
            "comentario"  => trim($d["feedback_texto"] ?? ""),
            "notas"       => []
        ];
    }

    $rel[$id]["notas"][] = "{$d["numero_pergunta"]}. {$d["texto_pergunta"]}: {$d["nota"]}";
}

/* ==========================
   GERAR PDF
   ========================== */
$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont("Arial", "B", 16);
$pdf->Cell(0, 10, t("Relatório de Avaliações"), 0, 1, "C");
$pdf->Ln(5);

$pdf->SetFont("Arial", "", 12);

foreach ($rel as $r) {

    $pdf->SetFont("Arial", "B", 12);
    $pdf->Cell(0, 7, t("Data: ") . t($r["data"]), 0, 1);

    $pdf->SetFont("Arial", "", 12);
    $pdf->Cell(0, 6, t("Dispositivo: ") . t($r["dispositivo"]), 0, 1);
    $pdf->Cell(0, 6, t("Setor: ") . t($r["setor"]), 0, 1);

    $pdf->Ln(2);
    $pdf->SetFont("Arial", "B", 12);
    $pdf->Cell(0, 6, t("Notas:"), 0, 1);

    $pdf->SetFont("Arial", "", 12);
    foreach ($r["notas"] as $n) {
        $pdf->MultiCell(0, 6, t($n));
    }

    $pdf->Ln(2);
    $pdf->SetFont("Arial", "B", 12);
    $pdf->Cell(0, 6, t("Comentário:"), 0, 1);

    $pdf->SetFont("Arial", "", 12);

    $coment = $r["comentario"] === "" ? "(sem comentário)" : $r["comentario"];
    $pdf->MultiCell(0, 6, t($coment));

    $pdf->Ln(5);
    $pdf->Cell(0, 0, t(str_repeat("-", 95)), 0, 1);
    $pdf->Ln(5);
}

$pdf->Output("I", "relatorio.pdf");
exit;
?>
