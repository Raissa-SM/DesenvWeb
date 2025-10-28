<link rel="stylesheet" href="style.css">

<?php
include 'funcoes.php';

$conn = conectarBanco();

$nome      = $_POST['Nome']      ?? '';
$sobrenome = $_POST['Sobrenome'] ?? '';
$email     = $_POST['Email']     ?? '';
$senha     = $_POST['Senha']     ?? '';
$cidade    = $_POST['Cidade']    ?? '';
$estado    = $_POST['Estado']    ?? '';

$aDados = [$nome, $sobrenome, $email, $senha, $cidade, $estado];

if (inserirPessoa($conn, $aDados)) {
    echo "Dados inseridos com sucesso!";
} else {
    echo "Erro ao inserir os dados.";
}

echo '<br><br><a href="cadpessoa.html">Voltar</a>';
?>
