<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Resultado - Atividade 1</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php

    $valorVista = $_POST['v1'];
    $parcelas = $_POST['v2'];
    
    if ($parcelas < 36) {
        $juros = 2;
    } 
    else if ($parcelas < 48) {
        $juros = 2.3;
    } 
    else if ($parcelas < 60) {
        $juros = 2.6;
    }
    else {
        $juros = 2.9;
    }

    $total = $valorVista * ((1 + ($juros / 100)) ** $parcelas);
    $valorParcela = $total / $parcelas;

    echo "<p>Valor a vista → R$ " . number_format($valorVista, 2, ',', '.') . "</p>";
    echo "<p>Parlelamento → $parcelas vezes de R$ " . number_format($valorParcela, 2, ',', '.') . "</p>"; 
    echo "<p>Valor total a pagar → R$ " . number_format($total, 2, ',', '.') . "</p>";     

    echo "<p>Juquinha pagará R$ " . number_format($juros, 1, ',', '.') . " de juros compostos.</p>";

    echo "<a href='javascript:history.go(-1)'>Voltar</a></br>"; 
    echo "<a href='javascript:history.go(-2)'>Início</a>"; 
?>

</body>
</html>