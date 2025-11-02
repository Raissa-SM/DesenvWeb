<?php
    require_once "model/pessoa.php";
    require_once "model/contato.php";
    require_once "model/endereco.php";


    $pessoa = new Pessoa();
    $pessoa->setNome("Raíssa");
    $pessoa->setSobreNome("Malkowski");
    $pessoa->setDataNascimento(new DateTime("15-07-2005"));
    $pessoa->setCpfCnpj("090.257.019-65");

    $cont1 = new Contato(1, "Pessoal", "raissamazzi@gmail.com");
    $cont2 = new Contato(2, "WhatsApp", "(47) 99997-1487");

    $pessoa->addContato($cont1);
    $pessoa->addContato($cont2);

    $endereco = new Endereco("Rua Cleto Barros Westphalen", "Sumaré", "Rio do Sul", "SC", "89165-546");
    $pessoa->setEndereco($endereco);

    echo $pessoa->descricaoGeral();
?>