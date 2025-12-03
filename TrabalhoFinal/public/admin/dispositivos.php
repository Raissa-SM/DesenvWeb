<?php include "layout/header.php"; ?>

<div class="top-bar">
    <h1>Dispositivos</h1>
    <button class="btn" onclick="abrirModalNovoDispositivo()">+ Novo Dispositivo</button>
</div>


<div class="tabela-container">
    <table id="tabelaDispositivos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Setor</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Modal Novo -->
<div id="modalNovoDispositivo" class="modal oculto">
    <div class="modal-content">
        <h3>Novo Dispositivo</h3>

        <input id="novoNomeDispositivo" placeholder="Nome do dispositivo">
        <select id="novoSetor"></select>

        <div class="modal-btns">
            <button onclick="salvarNovoDispositivo()" class="btn">Salvar</button>
            <button onclick="closeAllModals()" class="btn btn-cancel">Cancelar</button>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div id="modalEditarDispositivo" class="modal oculto">
    <div class="modal-content">
        <h3>Editar Dispositivo</h3>

        <input id="editarNomeDispositivo">
        <select id="editarSetor"></select>
        <input type="hidden" id="editarIdDispositivo">

        <div class="modal-btns">
            <button onclick="salvarEdicaoDispositivo()" class="btn">Atualizar</button>
            <button onclick="closeAllModals()" class="btn btn-cancel">Cancelar</button>
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>
