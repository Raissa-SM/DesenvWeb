<?php include "layout/header.php"; ?>

<div class="top-bar">
    <h1>Relatórios</h1>

    <div class="relatorios-botoes">
        <a id="btnExportExcel" class="btn-export">📊 Exportar Excel</a>
        <a id="btnExportPdf" class="btn-export">📄 Exportar PDF</a>
    </div>
</div>

<!-- ===================== FILTROS ===================== -->
<div class="filtros-box">
    <div class="filtros-linha">

        <div class="filtro-item">
            <label for="filtroDataIni">Data início:</label>
            <input type="date" id="filtroDataIni">
        </div>

        <div class="filtro-item">
            <label for="filtroDataFim">Data fim:</label>
            <input type="date" id="filtroDataFim">
        </div>

        <div class="filtro-item">
            <label for="filtroSetor">Setor:</label>
            <select id="filtroSetor"></select>
        </div>

        <div class="filtro-item">
            <label for="filtroDispositivo">Dispositivo:</label>
            <select id="filtroDispositivo"></select>
        </div>

        <button id="btnAplicarFiltro" class="btn">Filtrar</button>
    </div>
</div>

<!-- ===================== TABELA ===================== -->
<div class="tabela-container">
    <h2>Lista de Avaliações</h2>

    <table id="tabelaRelatorio">
        <thead>
            <tr>
                <th>Data</th>
                <th>Dispositivo</th>
                <th>Setor</th>
                <th>Notas</th>
                <th>Comentário</th>
            </tr>
        </thead>

        <tbody></tbody>
    </table>
</div>

<?php include "layout/footer.php"; ?>
