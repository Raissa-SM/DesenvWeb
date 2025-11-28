<?php
$conn = require_once __DIR__ . "/../../../src/db.php";
require_once __DIR__ . "/../../../src/model/session.php";

$session = new Session();
$session->iniciaSessao();

// Verifica se admin está logado
if (!$session->getDadoSessao('usuario_admin')) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="../css/styleAdmin.css">
</head>

<body>

<!-- Botão mobile -->
<button class="toggle-menu" onclick="toggleSidebar()">☰</button>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">

    <h2>Admin</h2>

    <ul class="sidebar-nav">
        <li>
            <a href="dashboard.php"
               class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">
               📊 Dashboard
            </a>
        </li>

        <li>
            <a href="setores.php"
               class="<?= basename($_SERVER['PHP_SELF']) == 'setores.php' ? 'active' : '' ?>">
               🏢 Setores
            </a>
        </li>

        <li>
            <a href="dispositivos.php"
               class="<?= basename($_SERVER['PHP_SELF']) == 'dispositivos.php' ? 'active' : '' ?>">
               💻 Dispositivos
            </a>
        </li>

        <li>
            <a href="perguntas.php"
               class="<?= basename($_SERVER['PHP_SELF']) == 'perguntas.php' ? 'active' : '' ?>">
               ❓ Perguntas
            </a>
        </li>

        <li>
            <a href="relatorios.php"
               class="<?= basename($_SERVER['PHP_SELF']) == 'relatorios.php' ? 'active' : '' ?>">
               📑 Relatórios
            </a>
        </li>

        <li>
            <a href="#" onclick="confirmarLogout(event)">
                🔒 Sair
            </a>
        </li>
    </ul>
</aside>

<!-- CONTEÚDO PRINCIPAL -->
<div class="main-content">
