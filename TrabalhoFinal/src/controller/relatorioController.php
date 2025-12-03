<?php
require_once __DIR__ . "/../db.php";

header("Content-Type: application/json");

// Verifica se ação foi enviada (JS manda acao=filtrar)
$acao = $_POST["acao"] ?? null;

if ($acao !== "filtrar") {
    echo json_encode(["erro" => "Ação inválida"]);
    exit;
}

// Filtros recebidos via POST (compatível com admin.js)
$dataInicio  = $_POST["dataIni"] ?? null;
$dataFim     = $_POST["dataFim"] ?? null;
$setor       = $_POST["setor"] ?? null;
$dispositivo = $_POST["disp"] ?? null;

// Base da query
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

// FILTROS DINÂMICOS
if (!empty($dataInicio)) {
    $sql .= " AND a.data_hora::date >= :dataInicio";
    $params[":dataInicio"] = $dataInicio;
}

if (!empty($dataFim)) {
    $sql .= " AND a.data_hora::date <= :dataFim";
    $params[":dataFim"] = $dataFim;
}

if (!empty($setor)) {
    $sql .= " AND s.id_setor = :setor";
    $params[":setor"] = $setor;
}

if (!empty($dispositivo)) {
    $sql .= " AND d.id_dispositivo = :dispositivo";
    $params[":dispositivo"] = $dispositivo;
}

$sql .= "
    ORDER BY a.data_hora DESC, p.numero_pergunta
";

// Executa consulta
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// AGRUPAMENTO POR AVALIAÇÃO
$agrupado = [];

foreach ($rows as $r) {
    $id = $r["id_avaliacao"];

    if (!isset($agrupado[$id])) {
        $agrupado[$id] = [
            "id"         => $id,
            "data"       => $r["data"],
            "nome_dispositivo" => $r["nome_dispositivo"],
            "nome_setor" => $r["nome_setor"],
            "feedback"   => trim($r["feedback_texto"] ?? ""),
            "notas"      => []
        ];
    }

    $agrupado[$id]["notas"][] = [
        "numero"   => $r["numero_pergunta"],
        "nota"     => $r["nota"],
        "texto"    => $r["texto_pergunta"]
    ];
}

echo json_encode(array_values($agrupado));
exit;
?>
