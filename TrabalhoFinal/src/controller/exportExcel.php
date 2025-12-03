<?php
require_once "../db.php";

// IMPORTANTE: Excel precisa disso para interpretar corretamente UTF-8
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=relatorio.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Enviar BOM para Excel reconhecer UTF-8
echo "\xEF\xBB\xBF";

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
   AGRUPAR
   ========================== */
$rel = [];

foreach ($dados as $d) {
    $id = $d["id_avaliacao"];

    if (!isset($rel[$id])) {
        $rel[$id] = [
            "data"        => $d["data"],
            "dispositivo" => $d["nome_dispositivo"],
            "setor"       => $d["nome_setor"],
            "notas"       => [],
            "comentario"  => trim($d["feedback_texto"] ?? "")
        ];
    }

    $rel[$id]["notas"][] = "{$d["numero_pergunta"]}. {$d["texto_pergunta"]}: {$d["nota"]}";
}

/* ==========================
   EXCEL (HTML)
   ========================== */
echo "<meta charset='UTF-8'>";
echo "<table border='1'>";
echo "<tr>
        <th>Data</th>
        <th>Dispositivo</th>
        <th>Setor</th>
        <th>Notas</th>
        <th>Comentário</th>
      </tr>";

foreach ($rel as $r) {
    echo "<tr>";
    echo "<td>{$r["data"]}</td>";
    echo "<td>{$r["dispositivo"]}</td>";
    echo "<td>{$r["setor"]}</td>";
    echo "<td>" . implode("<br>", $r["notas"]) . "</td>";

    $comentario = $r["comentario"] ?: "(sem comentário)";
    echo "<td>{$comentario}</td>";

    echo "</tr>";
}

echo "</table>";
exit;
?>
