<?php 
    include "layout/header.php"; 
    require_once __DIR__ . "/../../src/lib/fpdf.php";
    $pdf = new FPDF();
?>

    <div class="relatorios-botoes">
        <a href="../../src/controller/exportExcel.php" class="btn-export">📊 Exportar Excel</a>
        <a href="../../src/controller/exportPdf.php" class="btn-export">📄 Exportar PDF</a>
    </div>


    <h1>Minha Página</h1>

<?php include "layout/footer.php"; ?>
