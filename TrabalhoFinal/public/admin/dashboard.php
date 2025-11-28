<?php
    include __DIR__ . '/layout/header.php';
    require_once __DIR__ . '/../../src/controller/DashboardController.php';

    // Busca todos os dados prontos do controller
    $dados = DashboardController::getDadosDashboard($conn);

    // Cards resumidos
    $cards = [
        ["Avaliações hoje",            $dados["totalHoje"]],
        ["Avaliações no mês",          $dados["totalMes"]],
        ["Dispositivos ativos",        $dados["dispositivos"]],
        ["Perguntas ativas",           $dados["perguntas"]],
        ["Média geral",                number_format($dados["mediaGeral"], 2, ',', '.')]
    ];

    // Dados JS
    $jsonDashboard = json_encode([
        "distNotas"       => $dados["distNotas"],
        "ult7dias"        => $dados["ult7dias"],
        "porDispositivo"  => $dados["porDispositivo"],
        "mediasPorSetor"  => $dados["mediasPorSetor"]
    ]);
?>

<div class="top-bar">
    <h1>Dashboard</h1>
</div>

<!-- ===== CARDS RESUMO ===== -->
<div class="cards">
    <?php foreach ($cards as $c): ?>
        <div class="card">
            <h3><?= $c[0] ?></h3>
            <div class="valor"><?= $c[1] ?></div>
        </div>
    <?php endforeach; ?>
</div>

<!-- ===== GRÁFICO: AVALIAÇÕES NOS ÚLTIMOS 7 DIAS ===== -->
<div class="grafico-box">
    <h3 class="titulo-grafico">📅 Avaliações — Últimos 7 dias</h3>
    <canvas id="chartUlt7Dias" height="120"></canvas>
</div>

<!-- ===== GRÁFICOS LADO A LADO ===== -->
<div class="grafico-box grafico-duplo">
    <div class="linha-grafico">

        <!-- Distribuição de notas -->
        <div class="grafico-item">
            <h3 class="titulo-grafico">📊 Distribuição de Notas (0 a 10)</h3>
            <canvas id="chartNotas" height="220"></canvas>
        </div>

        <!-- Avaliações por dispositivo -->
        <div class="grafico-item">
            <h3 class="titulo-grafico">💻 Avaliações por Dispositivo</h3>
            <canvas id="chartPorDispositivo" height="220"></canvas>
        </div>

    </div>
</div>


<!-- ===== TABELAS ===== -->
<div class="grid-duas-colunas">


    <!-- Média por setor -->
    <div class="tabela-container">
        <h3>Média por Setor</h3>
        <table>
            <thead>
                <tr>
                    <th>Setor</th>
                    <th>Média</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dados["mediasPorSetor"] as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nome_setor']) ?></td>
                    <td><?= number_format((float)$row['media'], 2, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Últimos Feedbacks -->
    <div class="tabela-container">
        <h3>Últimos Feedbacks</h3>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Dispositivo</th>
                    <th>Comentário</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($dados["ultimosFeedbacks"]) === 0): ?>
                    <tr><td colspan="3">Nenhum feedback encontrado</td></tr>
                <?php else: ?>
                    <?php foreach ($dados["ultimosFeedbacks"] as $f): ?>
                    <tr>
                        <td><?= date('d/m/Y H:i', strtotime($f['data_hora'])) ?></td>
                        <td><?= htmlspecialchars($f['nome_dispositivo']) ?></td>
                        <td><?= htmlspecialchars($f['feedback_texto']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- ===== PASSA DADOS AO JS ===== -->
<script>
    window.DASHBOARD_DATA = <?= $jsonDashboard ?>;
</script>

<?php include __DIR__ . '/layout/footer.php';?>
