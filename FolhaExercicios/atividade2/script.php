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

    if ($val1 % 2 == 0) {
        echo "<p>O valor $val1 é divisível por 2</p>";
    } 
    else {
        echo "<p>O valor $val1 não é divisível por 2</p>";
    } 
    
    echo "<p>" . $val1 . " / 2 = " . intdiv($val1, 2) . " Resto: " . $val1 % 2 . "</p>";

    echo "<a href='javascript:history.go(-1)'>Voltar</a></br>"; 
    echo "<a href='javascript:history.go(-2)'>Início</a>"; 
?>

</body>
</html>