<form method="POST" action="../src/controller/LoginController.php">
    <input name="login" placeholder="Login">
    <input name="senha" type="password" placeholder="Senha">
    <button>Entrar</button>
</form>

<?php if (isset($_GET['erro'])){
    echo "<p style='color:red;'>Usuário ou senha inválidos!</p>";
} ?>
