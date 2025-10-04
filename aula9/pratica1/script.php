<?php
    $notas = array(10,8,6,4,7,9);
    $faltas = array(1,1,1,1,0,0,1,1,0,1,1,1,0,1,0);

    function media ($notas){
        $soma = 0;
        for($i = 0; $i < count($notas); $i++) {
            $soma += $notas[$i];
        }
        return $soma / count($notas);
    }

    function status ($valor, $criterio) {
        if ($valor > $criterio) {
            return true;
        }
        else {
            return false;
        }
    }

    function frequencia ($faltas) {
        $soma = 0;
        for($i = 0; $i < count($faltas); $i++) {
            $soma += $faltas[$i];
        }
        return ($soma / count($faltas)) * 100;
    }

    function aprovadoReprovado ($boolean) {
        if ($boolean) {
            return "Aprovado";
        }
        else {
            return "Reprovado";
        }
    }

    echo "Média: " . media($notas);
    
    echo "</br>Status: ". aprovadoReprovado($status = status(media($notas), 7));
    
    echo "</br>Faltas: " . frequencia($faltas);

    echo "</br>Status: " . aprovadoReprovado(status(frequencia($faltas), 70));

?>