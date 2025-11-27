<?php
session_start();

// Se já estiver logado, manda para o dashboard
if (isset($_SESSION['usuario_admin'])) {
    header("Location: dashboard.php");
    exit;
}

// Verifica mensagem de erro (via GET)
$erro = isset($_GET['erro']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrativo</title>

    <link rel="stylesheet" href="../css/styleAdmin.css">
</head>

<body class="login-body">

    <div class="login-container">

        <h2 class="login-title">Acesso Restrito</h2>
        <p class="login-subtitle">Área administrativa do sistema</p>

        <form method="POST" action="../../src/controller/loginController.php" class="login-form">

            <input type="hidden" name="acao" value="loginAdmin">

            <input type="text" name="login" placeholder="Login" required>
            <input type="password" name="senha" placeholder="Senha" required>

            <button type="submit" class="login-btn">Entrar</button>

        </form>

        <?php if ($erro): ?>
            <div class="login-error">
                Usuário ou senha inválidos!
            </div>
        <?php endif; ?>

    </div>

</body>
</html>
