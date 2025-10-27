<html lanb="pt-br">

    <head>
        <meta charset="UTF-8">
        <title> Pratica 1 - web </title> 
        <style>
            table {
                
                background-color: rgba(231, 240, 244);
                text-align: left;
                border-collapse: collapse;
            }
            th {
                background-color: rgba(45, 162, 191);
                color: white;
            }
            th, td {
                border: 1px solid white;
                min-width: 120px;
                padding: 3px 5px;
            }
            tr:nth-child(even) {
                background-color: rgba(204, 223, 232);
            }
        </style>
    </head>
    <body>
        <h1>Boletim</h1>
        <table>
            <?php
                $t = array(array("Disciplina", "Faltas", "Média"),
                     array("Matemática", 5, 8.5),
                     array("Português", 2, 9),
                     array("Geografia", 10, 6),
                     array("Educação Física", 2, 8));
                     
                for ($i = 0; $i < 5; $i++) { // utilizei a lógica de matrizes aprendida em algorítmos
                    echo "<tr>";
                    for ($j = 0; $j < 3; $j++) {
                        if ($i == 0) {
                            echo "<th>" . $t[$i][$j] . "</th>";
                        }
                        else {
                            echo "<td>" . $t[$i][$j] . "</td>";
                        }
                    }
                    echo "</tr>";
                }
            ?>
        </table>
    </body>
</html>