<?php include __DIR__ . '/layout/header.php'; ?>

<div class="top-bar">
    <h1>Setores</h1>
    <button class="btn" onclick="abrirModalNovoSetor()">+ Novo Setor</button>
</div>


<div class="tabela-container">
    <table id="tabelaSetores">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome do Setor</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Modal Novo -->
<div id="modalNovoSetor" class="modal oculto">
    <div class="modal-content">
        <h3>Novo Setor</h3>
        <input id="novoNomeSetor" placeholder="Nome do setor">
        <div class="modal-btns">
            <button onclick="salvarNovoSetor()" class="btn">Salvar</button>
            <button onclick="fecharModais()" class="btn btn-cancel">Cancelar</button>    
        </div>
        
    </div>
</div>

<!-- Modal Editar -->
<div id="modalEditarSetor" class="modal oculto">
    <div class="modal-content">
        <h3>Editar Setor</h3>
        <input id="editarNomeSetor">
        <input type="hidden" id="editarIdSetor">
        <div class="modal-btns">
            <button onclick="salvarEdicaoSetor()" class="btn">Atualizar</button>
            <button onclick="fecharModais()" class="btn btn-cancel">Cancelar</button>    
        </div>
        
    </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>
