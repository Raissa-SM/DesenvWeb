<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Avaliação</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="tela" onload="iniciarAvaliacao()">
    <div class="container">
        <form method="POST" action="obrigado.html" id="formAvaliacao">

            <?php
            require_once "../src/model/perguntas.php";
            require_once "../src/funcoes.php";
            require_once "../src/db.php";

            $arrayPerguntas = Perguntas::dbAtivasParaObjeto();
            $total = count($arrayPerguntas);

            for ($index = 0; $index < $total; $index++) {
                echo "<div class='pergunta oculto' id='pergunta$index' data-index='$index' data-tipo='{$arrayPerguntas[$index] -> getTipo()}' data-total='$total'>";
                echo "<label>" . $arrayPerguntas[$index] -> getTexto() . "</label><br>";

                if ($arrayPerguntas[$index] -> getTipo() == 1) {
                    echo "<div class='botoes'>"; 
                    for ($i = 0; $i <= 10; $i++) {
                        echo "<button type='button' class='btnResposta' data-valor='$i' data-index='$index'>$i</button>";
                    }
                    echo "</div>";
                } else {
                    echo "<input type='text' class='inputTexto' data-index='$index'>";
                }

                echo "</div>";
            }
            ?>
            <footer>
                <button type='button' id='btnVoltar'>Voltar</button>
                <button type="submit" id="btnSubmit" class="enviar oculto">Enviar Avaliação</button>
            </footer>
        </form>
    </div>
    

    <script src="js/script.js"></script>
</body>
</html>
