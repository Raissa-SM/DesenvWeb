<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Avaliação</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="tela" onload="iniciarAvaliacao()">
    <div class="container">
        <form method="POST" id="formAvaliacao">

            <?php
            require_once "../src/model/perguntas.php";
            require_once "../src/db.php";

            $perguntas = Perguntas::getAtivas($conn);
            $total = count($perguntas);

            for ($index = 0; $index < $total; $index++) {
                $idPergunta = $perguntas[$index]->getId();
                $tipo = $perguntas[$index]->getTipo();
                $texto = $perguntas[$index]->getTexto();

                echo "<div class='pergunta oculto' 
                      data-idpergunta='{$idPergunta}' 
                      data-index='{$index}' 
                      data-tipo='{$tipo}' 
                      data-total='{$total}'>";

                echo "<label>{$texto}</label><br>";

                if ($tipo == 1) {
                    echo "<div class='botoes'>"; 
                    for ($i = 0; $i <= 10; $i++) {
                        echo "<input type='button' class='btnResposta' value='$i' data-idpergunta='{$idPergunta}'>";
                    }
                    echo "</div>";
                } else {
                    echo "<input type='text' class='inputTexto' name='feedback' placeholder='Digite seu comentário...'>";
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
