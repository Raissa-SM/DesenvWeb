<?php
    $sal1 = 1000;
    $sal2 = 2000;

    $sal2 = $sal1;

    $sal2++;

    $sal1 *= 1.1;

    echo "Salário 1: $sal1, Salário 2: $sal2";

    echo "</br>";

    if ($sal1 > $sal2) {
        echo "O valor da variável 1 é maior que o valor da variável 2";
    }
    elseif ($sal1 < $sal2) {
        echo "O valor da variável 2 é maior que o valor da variável 1";
    }
    else {
        echo "Os valores são iguais";
    }

    echo "</br>";

    $status = array("Ótimo", "Muito Bom", "Bom");
    foreach ($status as $valor) {
        echo "$valor <br>";
    }

    for ($i = 0; $i < 100; ++$i) {
        $sal1++;
        if ($i == 49) {
            break;
        }
    }

    if ($sal1 < $sal2) {
        echo "Salário 1: $sal1";
    }
?>