<?php
    require_once "model/session.php";

    $session = new Session();

    if (!$session -> getUsuarioSessao()) {
        echo "Sessão iniciada!<br>";

        $usuario = new Usuario('Raíssa', 'raissa@gmail.com', '123456');
        $usuario -> setUsuarioSessao();
    }
    else {
        echo "Falha ao iniciar sessão";
        $session -> finalizaSessao();
    }

    
?>