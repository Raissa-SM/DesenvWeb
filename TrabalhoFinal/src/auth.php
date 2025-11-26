<?php
    require_once 'model/session.php';
    require_once 'model/usuario.php';

    $session = new Session();
    if($session->iniciaSessao()) {
        echo "Sessão iniciada com sucesso. <br>";

        if(!$session->getUsuarioSessao()) {
            //Obter os dados do usuário da tela de login
            $login = $_POST['login'];
            $senha = $_POST['senha'];

            $usuario = new Usuario($login, $senha);
            if($usuario->validaUsuario()) {
                echo "Usuário validado com sucesso. <br>";
            } else {
                echo "Falha na validação do usuário. <br>";
            }
            $session->setUsuarioSessao($usuario);
        } else {
            echo "Usuário da sessão: " . $session->getUsuarioSessao();
        }
    } else {
        echo "Falha ao iniciar sessão.";
        $session->finalizaSessao();
    }
?>