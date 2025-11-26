<?php
    require_once __DIR__ . "/../../src/db.php";
    require_once __DIR__ . "/../../src/funcoes.php";
    require_once __DIR__ . "/../../src/model/dispositivo.php";
    session_start();

    $setores = Dispositivo::getPorSetor($conn);
    // Verifica se já tem sessão
    if (!isset($_SESSION['id_dispositivo'])) {    
        $temDispositivoSelecionado = 'false';
    }
    else {
        $identificacao = Dispositivo::getDescricaoCompleta($conn, $_SESSION['id_dispositivo']); 
        $temDispositivoSelecionado = 'true'; 
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script>
        const temDispositivoSelecionado = <?=$temDispositivoSelecionado?>;
    </script>
    <title>Avalie-nos</title>
</head>
<body class="tela">
    <div class="container">
        <?php echo "<div class='identificacao'>" . $identificacao . "</div>"; ?>
        <div class="texto">
            <h1>Avalie-nos!</h1>
            <h2>Ajude-nos a aprimorar nosso serviço</h2>
            <p>Sua avaliação é anônima, nenhuma informação pessoal é solicitada.</p>    
            <button onclick="window.location.href='index.php'">Iniciar</button>
        </div>
        <footer>
            <div></div>
            <img src="../imagens/user.png" alt="Admin" id="btnAdmin">
        </footer>
    </div>

    <!-- Modal de Login do Tablet -->
    <div class="overlay oculto" id="overlayLogin">
        <div class="modal">
            <h2>Login do Administrador</h2>

            <form id="formLoginTablet">
                <input type="password" id="senhaTablet" placeholder="Digite a senha" required>
                <button type="submit">Entrar</button>
                <button type="button" id="fecharLogin">Cancelar</button>
            </form>
        </div>
    </div>


    <!-- Modal de Seleção de Dispositivo -->
    <div class="overlay oculto" id="overlayDispositivo">
        <div class="modal">
            <h2>Selecione o Dispositivo</h2>
            <form id="formDispositivo">
                <?php
                    foreach ($setores as $nomeSetor => $disps) {
                        echo "<h3>$nomeSetor</h3>";
                        foreach ($disps as $d) {
                            echo "<button type='submit' name='id_dispositivo' value='{$d['id_dispositivo']}'>{$d['nome_dispositivo']}</button>";
                        }
                    }
                ?>
            </form>
        </div>
    </div>
    
    <script src="../js/script.js"></script>

</body>
</html>