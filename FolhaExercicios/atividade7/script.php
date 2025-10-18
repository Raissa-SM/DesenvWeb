<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Resultado - Atividade 1</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php

    function calcularJuros($valorVista, $valorParcela, $parcelas) {
        $totalPago = $valorParcela * $parcelas;
        $juros = $totalPago - $valorVista;
        return $juros;
    }

    $valorVista = $_POST["v1"];
    $valorParcela = $_POST["v2"];
    $parcelas = $_POST["v3"];

    $juros = calcularJuros($valorVista, $valorParcela, $parcelas);

    echo "<p>Valor a vista → R$ " . number_format($valorVista, 2, ',', '.') . "</p>";
    echo "<p>Financiamento → $parcelas vezes de R$ " . number_format($valorParcela, 2, ',', '.') . "</p>"; 
    echo "<p>Valor total a pagar → R$ " . number_format($valorVista + $juros, 2, ',', '.') . "</p>";   

    echo "<p>Mariazinha pagará R$ " . number_format($juros, 2, ',', '.') . " de juros.</p>";

    echo "<a href='javascript:history.go(-1)'>Voltar</a></br>"; 
    echo "<a href='javascript:history.go(-2)'>Início</a>"; 
?>

</body>
</html>