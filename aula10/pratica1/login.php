<?php
    session_start();

    if (!isset($_SESSION['usuario'])) {
        $_SESSION['usuario'] = $_POST['usuario'];
        $_SESSION['senha'] = $_POST['senha'];
        $_SESSION['inicio_sessao'] = date("d/m/Y H:i:s");

        echo "Sessão iniciada e usuário registrado.";
    } else {
        echo "Usuário já logado: " . $_SESSION['usuario'] . "</br>";
        echo "Início da sessao: " . $_SESSION['inicio_sessao'] . "</br>";
        echo '<a href="login.php">Recarregar</a>';
    }
?>