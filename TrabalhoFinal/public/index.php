<?php
    require_once "../src/perguntas.php";
    require_once "../src/funcoes.php";
    require_once "../src/db.php";

    $arrayPerguntas = getPerguntasDb($conn);

    echo "<form method='POST' action='../src/submit.php'>";

    foreach ($arrayPerguntas as $p) {
        echo "<label for='pergunta'>" . $p['texto_pergunta'] . "<br></label>";
        for ($i = 0; $i <= 10; $i++) {
            echo "<input type='button' value='$i'>";
        }
        echo "<br>";
        
    }

    echo "</form>"
?>