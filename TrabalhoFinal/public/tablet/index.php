<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Avaliação</title>
    <link rel="stylesheet" href="../css/styleTablet.css">
</head>
<body class="tela" onload="iniciarAvaliacao()">
    <div class="container">
        <form method="POST" id="formAvaliacao">
            <?php
            session_start();

            require_once __DIR__ . "/../../src/model/perguntas.php";
            require_once __DIR__ . "/../../src/model/dispositivo.php";
            require_once __DIR__ . "/../../src/db.php";

            echo "<div class='identificacao'>" . Dispositivo::getDescricaoCompleta($conn, $_SESSION['id_dispositivo']) . "</div>";

            $perguntas = Perguntas::getAtivasSetor($conn, $_SESSION['id_setor']);
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
                    echo "<textarea class='inputTexto textareaGrande' name='feedback' placeholder='Digite seu comentário...' rows='4'></textarea>";
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
    

    <script src="../js/script.js"></script>
</body>
</html>
