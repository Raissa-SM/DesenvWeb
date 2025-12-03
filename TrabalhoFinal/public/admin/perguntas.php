<?php include "layout/header.php"; ?>

<div class="top-bar">
    <h1>Perguntas</h1>
    <button id="btnNovaPergunta" class="btn" onclick="abrirModalNovaPergunta()" disabled>+ Nova Pergunta</button>
</div>

<div class="tabela-container">
    <h2 style="margin-bottom:15px;">Selecione um setor</h2>

    <select id="selectSetorPergunta" class="form-select" onchange="carregarPerguntasSetor()">
        <option value="">-- Selecione --</option>
    </select>

    <table id="tabelaPerguntas" style="margin-top:20px;">
        <thead>
            <tr>
                <th>Nº</th>
                <th>Pergunta</th>
                <th>Tipo</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>


<!-- ========== MODAL NOVA PERGUNTA ========== -->
<div id="modalNovaPergunta" class="modal oculto">
    <div class="modal-content">
        <h3>Nova Pergunta</h3>

        <select id="novoTipoPergunta">
            <option value="1">Nota (0–10)</option>
            <option value="0">Texto descritivo</option>
        </select>

        <input id="novoNumeroPergunta" placeholder="Número da pergunta (ordem)" type="number">
        <textarea id="novoTextoPergunta" placeholder="Texto da pergunta" style="width:100%; height:80px;" required></textarea>

        <div class="modal-btns">
            <button class="btn" onclick="salvarNovaPergunta()">Salvar</button>
            <button class="btn btn-cancel" onclick="fecharModais()">Cancelar</button>
        </div>
    </div>
</div>


<!-- ========== MODAL EDITAR ========== -->
<div id="modalEditarPergunta" class="modal oculto">
    <div class="modal-content">
        <h3>Editar Pergunta</h3>

        <input type="hidden" id="editarIdPergunta">

        <select id="editarTipoPergunta">
            <option value="1">Nota (0–10)</option>
            <option value="0">Texto descritivo</option>
        </select>

        <input id="editarNumeroPergunta" type="number">
        <textarea id="editarTextoPergunta" style="width:100%; height:80px;" required></textarea>

        <div class="modal-btns">
            <button class="btn" onclick="salvarEdicaoPergunta()">Atualizar</button>
            <button class="btn btn-cancel" onclick="fecharModais()">Cancelar</button>
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>
