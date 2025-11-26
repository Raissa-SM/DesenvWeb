<?php
require_once __DIR__ . "/../db.php";
require_once __DIR__ . "/../model/session.php";
require_once __DIR__ . "/../model/usuarioAdmin.php";
require_once __DIR__ . "/../model/usuarioTablet.php";

$session = new Session();
$session->iniciaSessao();

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
          $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

// LOGIN DO TABLET (via AJAX)

if (isset($_POST['acao']) && $_POST['acao'] === "loginTablet") {

    header("Content-Type: application/json");

    $senha = $_POST['senha'] ?? '';

    $tabletUser = new UsuarioTablet($senha);

    if ($tabletUser->valida($conn)) {

        $session->setDadoSessao('tablet_logado', true);

        echo json_encode(["status" => "ok"]);
        exit;
    }

    echo json_encode(["status" => "erro"]);
    exit;
}

// LOGIN DO ADMIN (form normal)

if (isset($_POST['acao']) && $_POST['acao'] === "loginAdmin") {

    $login = $_POST['login'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $admin = new UsuarioAdmin($login, $senha);

    if ($admin->valida($conn)) {

        $session->setDadoSessao('usuario_admin', $admin->getNome());

        header("Location: ../../public/admin/dashboard.php");
        exit;
    }

    header("Location: ../../public/admin/login.php?erro=1");
    exit;
}

// ACESSO INDEVIDO

header("Location: ../../public/admin/login.php");
exit;
