<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Avalie-nos</title>
</head>
<body class="tela">
    <div class="container">
        <form method="POST" action="../src/controller/LoginController.php">
            <input name="login" placeholder="Login">
            <input name="senha" type="password" placeholder="Senha">
            <button>Entrar</button>
        </form>
    </div>
</body>
</html>

<?php
    if (isset($_GET['erro'])){
        echo "<p style='color:red;'>Usuário ou senha inválidos!</p>";
    } 
?>
