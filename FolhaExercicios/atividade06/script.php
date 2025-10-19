<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Resultado - Atividade 1</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php

    $produtos = [
        "Batatinha" => ["preco" => 4.50, "kg" => $_POST['v1']],
        "Cenoura" => ["preco" => 7.00, "kg" => $_POST['v2']],
        "Laranja" => ["preco" => 2.50, "kg" => $_POST['v3']],
        "Maçã" => ["preco" => 3.00, "kg" => $_POST['v4']],
        "Melancia" => ["preco" => 5.00, "kg" => $_POST['v5']],
        "Repolho" => ["preco" => 1.00, "kg" => $_POST['v6']],
    ];

    $total = 0;

    foreach ($produtos as $nome => $info) {
        $subtotal = $info["preco"] * $info["kg"];
        $total += $subtotal;
        echo "<p>" . $info["kg"] . "Kg de $nome custam R$ " . number_format($subtotal, 2, ',', '.') . "</p>";
    }
    
    echo "</br><p>O valor total da compra será de R$ " . number_format($total, 2, ',', '.') . "</p>";
    
    echo "<p>Joãozinho tem R$ 50,00 para pagar as frutas e verduras.</p>";

    $diferença = 50 - $total;

    if ($diferença < 0) {
        echo "<p style='color:red'>Seu saldo é insuficiente, faltam R$ " . number_format(abs($diferença), 2, ',', '.') . " para Joãozinho pagar a conta.</p>";
    } 
    else if ($diferença == 0) {
        echo "<p style='color:green'>Seu saldo foi esgotado, Joãozinho gastou os R$ 50,00.</p>";
    } 
    else {
        echo "<p style='color:blue'>Seu saldo é suficiente, sobraram R$ " . number_format($diferença, 2, ',', '.') . " para Joãozinho gastar.</p>";
    }  

    echo "<a href='javascript:history.go(-1)'>Voltar</a></br>"; 
    echo "<a href='javascript:history.go(-2)'>Início</a>"; 
?>

</body>
</html>