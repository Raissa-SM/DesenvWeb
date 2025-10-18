<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Resultado - Atividade 1</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php

    $pastas = 
        array("bsn" =>
            array("3a Fase" =>
                array("desenvWeb", "bancoDados 1", "engSoft 1"),
                  "4a Fase" =>
                array("Intro Web", "bancoDados 1", "engSoft 1")));
    
    function mostrarArvore($itens, $nivel = 1) {
        foreach ($itens as $chave => $valor) {
            echo "<p>" . str_repeat("- ", $nivel) . " ";

            if (is_array($valor)) {
                echo $chave . "</p>";
                mostrarArvore($valor, $nivel + 1);
            } 
            else {
                echo $valor . "</p>";
            }
        }
    }

    mostrarArvore($pastas);
 
    echo "<a href='javascript:history.go(-1)'>Início</a>"; 
?>

</body>
</html>