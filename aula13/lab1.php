<?php
    require_once "model/pessoa.php";

    $pessoa1 = new Pessoa();
    $pessoa1 -> setNome("Raíssa");
    $pessoa1 -> setSobreNome("Malkowski");
    $pessoa1 -> setDataNascimento(new DateTime("2005-07-15"));

    echo $pessoa1 -> getNomeCompleto() . "</br>";
    echo $pessoa1 -> getDataInstancia() . "</br>";
    echo $pessoa1 -> getDataNascimento() -> format('d/m/Y') . "</br>";
    echo $pessoa1 -> getIdade();

?>