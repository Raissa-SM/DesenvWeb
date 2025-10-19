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
    $val3 = $_POST['v3'];
    
    $soma = $val1 + $val2 + $val3;

    if ($val1 > 10) {
        $cor = 'azul';
    } 
    else if ($val2 < $val3) {
        $cor = 'verde';
    } 
    else if ($val3 < $val1 AND $val3 < $val2) {
        $cor = 'vermelho';
    }
    else {
        $cor = '';
    }
    echo "<p>Valores: $val1, $val2 e $val3</p>";
    echo "<p class=$cor>Soma: $soma</p>";

    echo "<a href='javascript:history.go(-1)'>Voltar</a></br>"; 
    echo "<a href='javascript:history.go(-2)'>Início</a>"; 
?>

</body>
</html>