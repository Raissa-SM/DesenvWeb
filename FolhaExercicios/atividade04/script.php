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
        
    $area = $val1 * $val2;

    if ($area > 10) {
        $h = 'h1';
    } 
    else {
        $h = 'h3';
    }
    
    echo "<$h>A área do retângulo de lados $val1 e $val2 metros é $area metros quadrados.</$h>";

    echo "<a href='javascript:history.go(-1)'>Voltar</a></br>"; 
    echo "<a href='javascript:history.go(-2)'>Início</a>"; 
?>

</body>
</html>