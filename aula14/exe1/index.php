<?php
    require_once "model/calculadora.php";
    require_once "model/computador.php";

    $calc = new Calculadora();
    $calc -> setNumero1(1);    
    $calc -> setNumero2(2);   
    
    echo $calc -> somar() . "<br>";
    echo $calc -> subtrair() . "<br>";
    echo $calc -> dividir() . "<br>";
    echo $calc -> multiplicar() . "<br>";

    $comp = new Computador();
    $comp -> ligar();
    $comp -> desligar();
    echo "<br>" . $comp -> getStatus();
?>