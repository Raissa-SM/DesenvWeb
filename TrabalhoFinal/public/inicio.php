<?php
    session_start();
    require_once "../src/db.php";
    require_once "../src/funcoes.php";

    // Verifica se já tem sessão
    if (!isset($_SESSION['id_dispositivo'])) {
        $setores = getDispositivosPorSetor($conn);
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Avalie-nos</title>
</head>
<body class="tela">
    <div class="container">
        <?php echo "<div class='identificacao'>" . getDispositivoSetorById($conn, $_SESSION['id_dispositivo']) . "</div>"; ?>
        <div class="texto">
            <h1>Avalie-nos!</h1>
            <h2>Ajude-nos a aprimorar nosso serviço</h2>
            <p>Sua avaliação é anônima, nenhuma informação pessoal é solicitada.</p>    
            <button onclick="window.location.href='index.php'">Iniciar</button>
        </div>
        <footer>
            <div></div>
            <img src="imagens/user.png" alt="Admin" onclick="window.location.href='admin.php'">
        </footer>
    </div>

    <?php 
        if (!isset($_SESSION['id_dispositivo'])){
            echo "<div class='overlay' id='overlayDispositivo'>";
            echo "<div class='modal'>";
            echo "<h2>Selecione o Dispositivo</h2>";
            echo "<form id='formDispositivo'>";

            foreach ($setores as $nomeSetor => $disps) {
                echo "<h3>$nomeSetor</h3>";
                foreach ($disps as $d) {
                    echo "<button type='submit' name='id_dispositivo' value='{$d['id_dispositivo']}'>
                            {$d['nome_dispositivo']}
                        </button>";
                }
            }
            echo "</form></div></div>";
        }
    ?>

    <script src="js/script.js"></script>

</body>
</html>