<?php
    require_once "model/pessoa.php";
    require_once "model/contato.php";
    require_once "model/endereco.php";
    require_once "funcoes/function.php";

    //EU
    $eu = new Pessoa();
    $eu->setNome("Raíssa");
    $eu->setSobreNome("Sofka Mazzi");
    $eu->setDataNascimento(new DateTime("15-07-2005"));
    $eu->setCpfCnpj("090.257.019-65");

    $cont1Ra = new Contato(1, "Email Pessoal", "raissamazzi@gmail.com");
    $cont2Ra = new Contato(2, "WhatsApp", "(47) 99997-1487");

    $eu->addContato($cont1Ra);
    $eu->addContato($cont2Ra);

    $endereco = new Endereco("Rua Cleto Barros Westphalen", "Sumaré", "Rio do Sul", "SC", "89165-546");
    $eu->setEndereco($endereco);

    //echo $eu->descricaoGeral();

    //PAI
    $pai = new Pessoa();
    $pai->setNome("Cláudio");
    $pai->setSobreNome("Mazzi");
    $pai->setDataNascimento(new DateTime("29-01-1971"));
    $pai->setCpfCnpj("725.117.459-68");

    $cont1Pai = new Contato(1, "Email Pessoal", "claudiomazzi@gmail.com");
    $cont2Pai = new Contato(2, "WhatsApp", "(47) 99988-8551");

    $pai->addContato($cont1Pai);
    $pai->addContato($cont2Pai);

    $pai->setEndereco($endereco);

    //echo $pai->descricaoGeral();

    //MÃE
    $mae = new Pessoa();
    $mae->setNome("Nádia");
    $mae->setSobreNome("Sofka Mazzi");
    $mae->setDataNascimento(new DateTime("18-03-1964"));
    $mae->setCpfCnpj("482.278.709-53");

    $cont1Mae = new Contato(1, "Email Pessoal", "nadia-ssm@gmail.com");
    $cont2Mae = new Contato(2, "WhatsApp", "(47) 99998-4485");

    $mae->addContato($cont1Mae);
    $mae->addContato($cont2Mae);

    $mae->setEndereco($endereco);

    //echo $mae->descricaoGeral();
    
    //IRMÃ
    $le = new Pessoa();
    $le->setNome("Letícia");
    $le->setSobreNome("Sofka Mazzi");
    $le->setDataNascimento(new DateTime("07-06-2000"));
    $le->setCpfCnpj("090.256.999-60");

    $cont1Le = new Contato(1, "Email Pessoal", "leticiasmazzi@gmail.com");
    $cont2Le = new Contato(2, "WhatsApp", "(47) 99993-9206");

    $le->addContato($cont1Le);
    $le->addContato($cont2Le);

    $enderecoLe = new Endereco("Av Governador Pedro de Toledo", "Botafogo", "Campinas", "SP", "13070-752");
    $le->setEndereco($enderecoLe);

    //echo $le->descricaoGeral();

    //IRMÃO
    $fe = new Pessoa();
    $fe->setNome("Felipe");
    $fe->setSobreNome("Sofka Mazzi");
    $fe->setDataNascimento(new DateTime("14-01-2004"));
    $fe->setCpfCnpj("090.257.009-93");

    $cont1Fe = new Contato(1, "Email Pessoal", "felipesmazzi@gmail.com");
    $cont2Fe = new Contato(2, "WhatsApp", "(47) 99653-0029");

    $fe->addContato($cont1Fe);
    $fe->addContato($cont2Fe);

    $fe->setEndereco($endereco);

    //echo $fe->descricaoGeral();
    
    $familia = [$eu, $pai, $mae, $le, $fe];

    salvaPessoasJson($familia);
?>