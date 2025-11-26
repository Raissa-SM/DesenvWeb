<?php
    require_once __DIR__ . "/../config.php";

    // === CONEXÃO COM O BANCO ===
    try {
        $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo json_encode(["erro" => "Erro ao conectar: " . $e->getMessage()]);
        exit;
    } 
?>