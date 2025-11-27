<?php
// dashboard.php
// Inclui header (inicia sessão, verifica login, abre main-content)
include __DIR__ . '/layout/header.php';

// espera que $conn (PDO) esteja disponível via src/db.php incluído no header/layout


try {
    // 1) Totais rápidos
    $stmt = $conn->prepare("SELECT COUNT(*) FROM avaliacao WHERE data_hora::date = CURRENT_DATE");
    $stmt->execute();
    $totalHoje = (int) $stmt->fetchColumn();

    $stmt = $conn->prepare("SELECT COUNT(*) FROM avaliacao WHERE date_trunc('month', data_hora) = date_trunc('month', CURRENT_DATE)");
    $stmt->execute();
    $totalMes = (int) $stmt->fetchColumn();

    $stmt = $conn->prepare("SELECT COUNT(*) FROM dispositivo WHERE status_dispositivo = '1'");
    $stmt->execute();
    $dispositivosAtivos = (int) $stmt->fetchColumn();

    $stmt = $conn->prepare("SELECT COUNT(*) FROM pergunta WHERE status_pergunta = '1'");
    $stmt->execute();
    $perguntasAtivas = (int) $stmt->fetchColumn();

    // 2) Média geral (nota média)
    $stmt = $conn->prepare("
        SELECT ROUND(AVG(r.nota)::numeric, 2) as media_geral
        FROM resposta r
        JOIN avaliacao a ON r.id_avaliacao = a.id_avaliacao
    ");
    $stmt->execute();
    $mediaGeral = $stmt->fetchColumn();
    $mediaGeral = $mediaGeral !== null ? (float)$mediaGeral : 0;

    // 3) Média por setor
    $stmt = $conn->prepare("
        SELECT s.nome_setor, ROUND(AVG(r.nota)::numeric,2) as media
        FROM resposta r
        JOIN avaliacao a ON r.id_avaliacao = a.id_avaliacao
        JOIN dispositivo d ON a.id_dispositivo = d.id_dispositivo
        JOIN setor s ON d.id_setor = s.id_setor
        GROUP BY s.id_setor, s.nome_setor
        ORDER BY media DESC
    ");
    $stmt->execute();
    $mediasPorSetor = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 4) Últimos feedbacks textuais
    $stmt = $conn->prepare("
        SELECT a.feedback_texto, a.data_hora, d.nome_dispositivo
        FROM avaliacao a
        JOIN dispositivo d ON a.id_dispositivo = d.id_dispositivo
        WHERE a.feedback_texto IS NOT NULL AND trim(a.feedback_texto) <> ''
        ORDER BY a.data_hora DESC
        LIMIT 6
    ");
    $stmt->execute();
    $ultimosFeedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 5) Distribuição de notas (últimos 30 dias)
    $stmt = $conn->prepare("
        SELECT r.nota, COUNT(*) AS cnt
        FROM resposta r
        JOIN avaliacao a ON r.id_avaliacao = a.id_avaliacao
        WHERE a.data_hora >= (CURRENT_DATE - INTERVAL '30 days')
        GROUP BY r.nota
        ORDER BY r.nota
    ");
    $stmt->execute();
    $distNotas = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // nota => cnt

    // 6) Avaliações nos últimos 7 dias (por dia)
    $stmt = $conn->prepare("
        SELECT to_char(date_trunc('day', data_hora), 'YYYY-MM-DD') as dia, COUNT(*) AS cnt
        FROM avaliacao
        WHERE data_hora >= (CURRENT_DATE - INTERVAL '6 days')
        GROUP BY dia
        ORDER BY dia
    ");
    $stmt->execute();
    $ult7dias = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    // 7) Avaliações por dispositivo (top 10)
    $stmt = $conn->prepare("
        SELECT d.nome_dispositivo, COUNT(*) as cnt
        FROM avaliacao a
        JOIN dispositivo d ON a.id_dispositivo = d.id_dispositivo
        GROUP BY d.nome_dispositivo
        ORDER BY cnt DESC
        LIMIT 10
    ");
    $stmt->execute();
    $porDispositivo = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // tratamento simples — recomenda-se logar o erro
    echo "<div class='tabela-container'><p>Erro ao consultar dados: " . htmlspecialchars($e->getMessage()) . "</p></div>";
    include __DIR__ . '/layout/footer.php';
    exit;
}

// Preparar dados JS (json)
$js_distNotas = json_encode($distNotas);
$js_ult7dias = json_encode($ult7dias);
$js_porDispositivo = json_encode($porDispositivo);
$js_mediasPorSetor = json_encode($mediasPorSetor);
?>

<!-- HTML do conteúdo -->
<div class="top-bar">
    <h1>Dashboard</h1>
    <div class="admin-info">Bem-vindo, <?php echo htmlspecialchars($session->getDadoSessao('usuario_admin') ?? 'Administrador'); ?></div>
</div>

<!-- Cards -->
<div class="cards">
    <div class="card">
        <h3>Avaliações hoje</h3>
        <div class="valor"><?php echo $totalHoje; ?></div>
    </div>

    <div class="card">
        <h3>Avaliações no mês</h3>
        <div class="valor"><?php echo $totalMes; ?></div>
    </div>

    <div class="card">
        <h3>Dispositivos ativos</h3>
        <div class="valor"><?php echo $dispositivosAtivos; ?></div>
    </div>

    <div class="card">
        <h3>Perguntas ativas</h3>
        <div class="valor"><?php echo $perguntasAtivas; ?></div>
    </div>

    <div class="card">
        <h3>Média geral</h3>
        <div class="valor"><?php echo number_format($mediaGeral, 2, ',', '.'); ?></div>
    </div>
</div>

<!-- Gráficos -->
<div class="grafico-box">
    <canvas id="chartUlt7Dias" height="120"></canvas>
</div>

<div class="grafico-box" style="margin-top:18px;">
    <div style="display:flex; gap:20px;">
        <div style="flex:1;">
            <canvas id="chartNotas" height="220"></canvas>
        </div>
        <div style="flex:1;">
            <canvas id="chartPorDispositivo" height="220"></canvas>
        </div>
    </div>
</div>

<!-- Médias por setor e últimos comentários -->
<div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; margin-top:22px;">
    <div class="tabela-container">
        <h3>Média por Setor</h3>
        <table>
            <thead>
                <tr><th>Setor</th><th>Média</th></tr>
            </thead>
            <tbody>
                <?php foreach ($mediasPorSetor as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nome_setor']); ?></td>
                        <td><?php echo number_format((float)$row['media'],2,',','.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="tabela-container">
        <h3>Últimos Feedbacks</h3>
        <table>
            <thead><tr><th>Data</th><th>Dispositivo</th><th>Comentário</th></tr></thead>
            <tbody>
                <?php if (count($ultimosFeedbacks) === 0): ?>
                    <tr><td colspan="3">Nenhum feedback encontrado</td></tr>
                <?php else: ?>
                    <?php foreach ($ultimosFeedbacks as $f): ?>
                        <tr>
                            <td><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($f['data_hora']))); ?></td>
                            <td><?php echo htmlspecialchars($f['nome_dispositivo']); ?></td>
                            <td><?php echo htmlspecialchars($f['feedback_texto']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Passa dados para o JS do gráfico -->
<script>
    window.DASHBOARD_DATA = {
        distNotas: <?php echo $js_distNotas; ?>,
        ult7dias: <?php echo $js_ult7dias; ?>,
        porDispositivo: <?php echo $js_porDispositivo; ?>,
        mediasPorSetor: <?php echo $js_mediasPorSetor; ?>
    };
</script>

<?php
include __DIR__ . '/layout/footer.php';
