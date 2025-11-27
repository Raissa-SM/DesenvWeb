<?php
    require_once __DIR__ . "/../../src/model/session.php";

    $session = new Session();
    $session->iniciaSessao();
    $session->finalizaSessao();

    header("Location: login.php");
    exit;
?>