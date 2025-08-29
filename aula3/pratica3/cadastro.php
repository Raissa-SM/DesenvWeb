<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Cadastro</title>
    </head>
    <body>
        <h1>Info Pessoa Física</h1>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $no = $_POST["Nome"];
                $sn = $_POST["Sobrenome"];
                $na = $_POST["Nascimento"];
                $em = $_POST["Email"];
                $sx = $_POST["Sexo"];
                $co = $_POST["CorFavorita"];
                $en = $_POST["Endereco"];
                $ce = $_POST["CEP"];
                $es = $_POST["Estado"];

                echo "Nome: $no </br>"; 
                echo "Sobrenome: $sn </br>"; 
                echo "Data de Nascimento: $na </br>"; 
                echo "Email: $em </br>"; 
                echo "Sexo: $sx </br>"; 
                echo "Cor favorita: $co </br>"; 
                echo "Endereço: $en </br>"; 
                echo "CEP: $ce </br>"; 
                echo "Estado: $es </br>"; 
            }
        ?> 
    </body>
</html>