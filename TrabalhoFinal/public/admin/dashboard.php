<?php
    include __DIR__ . '/layout/header.php';
    require_once __DIR__ . '/../../src/controller/DashboardController.php';

    $dados = DashboardController::getDadosDashboard($conn);

    // Preparar dados individuais
    $totalHoje        = $dados["totalHoje"];
    $totalMes         = $dados["totalMes"];
    $dispositivos     = $dados["dispositivos"];
    $perguntas        = $dados["perguntas"];
    $mediaGeral       = number_format($dados["mediaGeral"], 2, ',', '.');

    // Dados JS
    $jsonDashboard = json_encode($dados);
?>
<div class="top-bar">
    <h1>Dashboard</h1>
</div>

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
        <div class="valor"><?php echo $dispositivos; ?></div>
    </div>

    <div class="card">
        <h3>Perguntas ativas</h3>
        <div class="valor"><?php echo $perguntas; ?></div>
    </div>

    <div class="card">
        <h3>Média geral</h3>
        <div class="valor"><?php echo $mediaGeral; ?></div>
    </div>

</div>

<script>
    window.DASHBOARD_DATA = <?php echo $jsonDashboard; ?>;
</script>

<?php include __DIR__ . '/layout/footer.php'; ?>
