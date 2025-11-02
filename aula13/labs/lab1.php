<?php
    require_once "model/pessoa.php";
    require_once "model/contato.php";

    $pessoa1 = new Pessoa();
    $pessoa1 -> setNome("Raíssa");
    $pessoa1 -> setSobreNome("Malkowski");
    $pessoa1 -> setDataNascimento(new DateTime("2005-07-15"));
    $pessoa1 -> setCpfCnpj("123.456.789-00");
    $pessoa1 -> setEndereco("Rua Cleto Barros Westphalen, 70, Rio do Sul, SC");

    $contatoTelefone = new Contato(2, "Telefone Residencial", "(11) 3456-7890");
    $pessoa1->addContato($contatoTelefone);

    echo $pessoa1 -> getNomeCompleto() . "</br>";
    echo $pessoa1 -> getDataNascimento() -> format('d/m/Y') . "</br>";
    echo $pessoa1 -> getIdade();

?>