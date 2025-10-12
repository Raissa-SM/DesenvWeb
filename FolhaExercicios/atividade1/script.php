<?php

    $num1 = $_POST['n1'];
    $num2 = $_POST['n2'];
    $num3 = $_POST['n3'];
    
    $soma = $num1 + $num2 + $num3;

    if ($num1 > 10) {
        $cor = 'blue';
    } 
    else if ($num2 < $num3) {
        $cor = "green";
    } 
    else if ($num3 < $num1 AND $num3 < $num2) {
        $cor = 'red';
    }
    else {
        $cor = 'black';
    }
    echo "Valores: $num1, $num2 e $num3";
    echo "<p style='color:$cor'>Soma: $soma</p>";
?>