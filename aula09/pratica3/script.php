<?php
    $valor = $_GET['valor'];
    $desconto = $_GET['desconto'];

    $valorDesconto = $valor - $desconto;

    echo "Valor: $valor </br>";
    echo "Desconto: $desconto </br>";
    echo "Valor com Desconto: $valorDesconto </br>";
?>