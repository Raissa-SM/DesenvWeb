<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Resultado - Atividade 1</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php

    $val1 = $_POST['v1'];
    $val2 = $_POST['v2'];
        
    $area = ($val1 * $val2) / 2;

    echo "<p>A área do triângulo retângulo de base $val1 e altura $val2 é $area.</p>";

    echo "<a href='javascript:history.go(-1)'>Voltar</a></br>"; 
    echo "<a href='javascript:history.go(-2)'>Início</a>"; 
?>

</body>
</html>