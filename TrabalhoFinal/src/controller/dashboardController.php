<?php
require_once __DIR__ . "/../db.php";
require_once __DIR__ . "/../model/Relatorio.php";

class DashboardController {

    public static function getDadosDashboard($conn){
        return [
            "totalHoje"        => Relatorio::totalHoje($conn),
            "totalMes"         => Relatorio::totalMes($conn),
            "dispositivos"     => Relatorio::dispositivosAtivos($conn),
            "perguntas"        => Relatorio::perguntasAtivas($conn),
            "mediaGeral"       => Relatorio::mediaGeral($conn),

            "mediasPorSetor"   => Relatorio::mediasPorSetor($conn),
            "ultimosFeedbacks" => Relatorio::ultimosFeedbacks($conn),
            "distNotas"        => Relatorio::distNotas30dias($conn),
            "ult7dias"         => Relatorio::ult7dias($conn),
            "porDispositivo"   => Relatorio::porDispositivo($conn),
        ];
    }
}
