/* ==========================================================
   FUNÇÕES GERAIS — usadas em Setores, Dispositivos, Perguntas,
   Relatórios e tudo no painel admin
   ========================================================== */

// Mostrar modal
function openModal(selector) {
    document.querySelector(selector).classList.remove("oculto");
    document.body.classList.add("modal-aberto");
    document.body.style.overflow = "hidden";
}

// Fechar todos modais
function closeAllModals() {
    document.querySelectorAll(".modal").forEach(m => m.classList.add("oculto"));
    document.body.classList.remove("modal-aberto");
    document.body.style.overflow = "auto";
}

// Enviar POST com URLSearchParams
async function apiPost(url, paramsObj) {
    const response = await fetch(url, {
        method: "POST",
        body: new URLSearchParams(paramsObj)
    });
    return response.json();
}

// Carregar tabela genérica
async function loadTable(url, params, tbodySelector, rowBuilder) {
    const lista = await apiPost(url, params);
    const tbody = document.querySelector(tbodySelector);
    tbody.innerHTML = "";
    lista.forEach(item => tbody.innerHTML += rowBuilder(item));
}

// Preencher SELECT com setores
async function loadSelect(url, params, selector, includeDefault = true) {
    const lista = await apiPost(url, params);
    const sel = document.getElementById(selector);
    sel.innerHTML = includeDefault ? `<option value="">-- Selecione --</option>` : "";
    lista.forEach(s => sel.innerHTML += `<option value="${s.id_setor}">${s.nome_setor}</option>`);
}

// Confirm dialog genérico
function confirmAction(msg) {
    return confirm(msg);
}

/* ==========================================================
   MENU E LOGOUT
   ========================================================== */

function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("mostrar");
}

function confirmarLogout(e) {
    e.preventDefault();
    if (confirm("Tem certeza que deseja sair da área administrativa?")) {
        window.location.href = "logout.php";
    }
}

/* ==========================================================
   SETORES
   ========================================================== */

function carregarSetores() {
    loadTable(
        "../../src/controller/setorController.php",
        { acao: "listar" },
        "#tabelaSetores tbody",
        (s) => `
            <tr class="${s.status_setor == '1' ? "" : "linha-inativa"}">
                <td>${s.id_setor}</td>
                <td>${s.nome_setor}</td>
                <td>${s.status_setor == '1' ? "Ativo" : "Inativo"}</td>
                <td>
                    <button class="btn-small" onclick="abrirModalEditar(${s.id_setor}, '${s.nome_setor}')">Editar</button>
                    <button class="btn-small" onclick="alterarStatus(${s.id_setor}, ${s.status_setor == '1' ? '0' : '1'})">
                        ${s.status_setor == '1' ? "Desativar" : "Ativar"}
                    </button>
                </td>
            </tr>
        `
    );
}

function abrirModalNovoSetor() { openModal("#modalNovoSetor"); }

function abrirModalEditar(id, nome) {
    document.getElementById("editarIdSetor").value = id;
    document.getElementById("editarNomeSetor").value = nome;
    openModal("#modalEditarSetor");
}

function salvarNovoSetor() {
    const nome = document.getElementById("novoNomeSetor").value.trim();
    if (!nome) return alert("O nome do setor é obrigatório.");

    apiPost("../../src/controller/setorController.php", { acao: "adicionar", nome })
        .then(res => {
            if (res.erro) return alert(res.erro);
            closeAllModals();
            carregarSetores();
        });
}

function salvarEdicaoSetor() {
    const id = document.getElementById("editarIdSetor").value;
    const nome = document.getElementById("editarNomeSetor").value.trim();
    if (!nome) return alert("O nome do setor é obrigatório.");

    apiPost("../../src/controller/setorController.php", { acao: "editar", id, nome })
        .then(res => {
            if (res.erro) return alert(res.erro);
            closeAllModals();
            carregarSetores();
        });
}

function alterarStatus(id, status) {
    if (!confirmAction(status == 0 ? "Desativar este setor?" : "Ativar este setor novamente?")) return;

    apiPost("../../src/controller/setorController.php", { acao: "status", id, status })
        .then(() => carregarSetores());
}

if (document.querySelector("#tabelaSetores")) carregarSetores();

/* ==========================================================
   DISPOSITIVOS
   ========================================================== */

function carregarDispositivos() {
    loadTable(
        "../../src/controller/dispositivoController.php",
        { acao: "listar" },
        "#tabelaDispositivos tbody",
        (d) => `
            <tr class="${d.status_dispositivo == '1' ? "" : "linha-inativa"}">
                <td>${d.id_dispositivo}</td>
                <td>${d.nome_dispositivo}</td>
                <td>${d.nome_setor}</td>
                <td>${d.status_dispositivo == '1' ? "Ativo" : "Inativo"}</td>
                <td>
                    <button class="btn-small" onclick="abrirModalEditarDispositivo(${d.id_dispositivo}, '${d.nome_dispositivo}', ${d.id_setor})">Editar</button>
                    <button class="btn-small" onclick="alterarStatusDispositivo(${d.id_dispositivo}, ${d.status_dispositivo == '1' ? '0' : '1'})">
                        ${d.status_dispositivo == '1' ? "Desativar" : "Ativar"}
                    </button>
                </td>
            </tr>
        `
    );
}

function carregarSetoresSelect(idSelect) {
    loadSelect("../../src/controller/dispositivoController.php", { acao: "listarSetores" }, idSelect, false);
}

function abrirModalNovoDispositivo() {
    carregarSetoresSelect("novoSetor");
    openModal("#modalNovoDispositivo");
}

function abrirModalEditarDispositivo(id, nome, setor) {
    carregarSetoresSelect("editarSetor");

    document.getElementById("editarIdDispositivo").value = id;
    document.getElementById("editarNomeDispositivo").value = nome;

    setTimeout(() => document.getElementById("editarSetor").value = setor, 100);

    openModal("#modalEditarDispositivo");
}

function salvarNovoDispositivo() {
    const nome = document.getElementById("novoNomeDispositivo").value.trim();
    const setor = document.getElementById("novoSetor").value;

    if (!nome) return alert("O nome do dispositivo é obrigatório.");
    if (!setor) return alert("Selecione um setor para o dispositivo.");

    apiPost("../../src/controller/dispositivoController.php", { acao: "adicionar", nome, setor })
        .then(res => {
            if (res.erro) return alert(res.erro);
            closeAllModals();
            carregarDispositivos();
        });
}

function salvarEdicaoDispositivo() {
    const id    = document.getElementById("editarIdDispositivo").value;
    const nome  = document.getElementById("editarNomeDispositivo").value.trim();
    const setor = document.getElementById("editarSetor").value;

    if (!nome) return alert("O nome do dispositivo é obrigatório.");
    if (!setor) return alert("Selecione um setor.");

    apiPost("../../src/controller/dispositivoController.php", {
        acao: "editar", id, nome, setor
    }).then(res => {
        if (res.erro) return alert(res.erro);
        closeAllModals();
        carregarDispositivos();
    });
}

function alterarStatusDispositivo(id, status) {
    if (!confirmAction(status == 0 ? "Desativar este dispositivo?" : "Ativar este dispositivo novamente?")) return;

    apiPost("../../src/controller/dispositivoController.php", { acao: "status", id, status })
        .then(() => carregarDispositivos());
}

if (document.querySelector("#tabelaDispositivos")) carregarDispositivos();

/* ==========================================================
   PERGUNTAS
   ========================================================== */

function carregarSelectSetoresPerg() {
    loadSelect("../../src/controller/setorController.php", { acao: "listar" }, "selectSetorPergunta");
}

function atualizarBotaoNovaPergunta() {
    const setor = document.getElementById("selectSetorPergunta").value;
    document.getElementById("btnNovaPergunta").disabled = !setor;
}

if (document.getElementById("selectSetorPergunta")) {
    carregarSelectSetoresPerg();
    addEventListener("change", atualizarBotaoNovaPergunta);
}

function carregarPerguntasSetor() {
    const id_setor = document.getElementById("selectSetorPergunta").value;
    if (!id_setor) return;

    loadTable(
        "../../src/controller/perguntaController.php",
        { acao: "listar", setor: id_setor },
        "#tabelaPerguntas tbody",
        (p) => `
            <tr class="${p.status_pergunta == '1' ? "" : "linha-inativa"}">
                <td>${p.numero_pergunta}</td>
                <td>${p.texto_pergunta}</td>
                <td>${p.tipo_pergunta == '1' ? "Nota" : "Texto"}</td>
                <td>${p.status_pergunta == '1' ? "Ativa" : "Inativa"}</td>
                <td>
                    <button class="btn-small" onclick="abrirModalEditarPergunta(${p.id_pergunta}, ${p.id_setor}, '${p.texto_pergunta}', ${p.numero_pergunta}, ${p.tipo_pergunta})">Editar</button>
                    <button class="btn-small" onclick="alterarStatusPergunta(${p.id_pergunta}, ${p.status_pergunta == '1' ? '0' : '1'})">
                        ${p.status_pergunta == '1' ? "Desativar" : "Ativar"}
                    </button>
                </td>
            </tr>
        `
    );
}

function alterarStatusPergunta(id, status) {
    if (!confirmAction(status == 0
        ? "Desativar esta pergunta?"
        : "Ativar esta pergunta novamente?"
    )) return;

    apiPost("../../src/controller/perguntaController.php",
        { acao: "status", id, status }
    ).then(res => {
        if (res.erro) return alert(res.erro);
        carregarPerguntasSetor();
    });
}

function proximoNumeroDisponivel() {
    const linhas = document.querySelectorAll("#tabelaPerguntas tbody tr");
    if (linhas.length === 0) return 1;

    let maior = 0;
    linhas.forEach(l => {
        const num = parseInt(l.children[0].innerText);
        if (num > maior) maior = num;
    });

    return maior + 1;
}

function abrirModalNovaPergunta() {
    document.getElementById("novoNumeroPergunta").value = proximoNumeroDisponivel();
    openModal("#modalNovaPergunta");
}

function salvarNovaPergunta() {
    const setor  = document.getElementById("selectSetorPergunta").value;
    const texto  = document.getElementById("novoTextoPergunta").value.trim();
    const numero = document.getElementById("novoNumeroPergunta").value;
    const tipo   = document.getElementById("novoTipoPergunta").value;

    if (!texto) return alert("O texto da pergunta é obrigatório.");

    apiPost("../../src/controller/perguntaController.php", {
        acao: "adicionar", setor, texto, numero, tipo
    }).then(res => {
        if (res.erro) return alert(res.erro);
        closeAllModals();
        carregarPerguntasSetor();
    });
}

function abrirModalEditarPergunta(id, setor, texto, numero, tipo) {
    document.getElementById("editarIdPergunta").value = id;
    document.getElementById("editarTextoPergunta").value = texto;
    document.getElementById("editarNumeroPergunta").value = numero;
    document.getElementById("editarTipoPergunta").value = tipo;

    const numInput = document.getElementById("editarNumeroPergunta");

    if (tipo == 0) {
        numInput.disabled = true;
        numInput.placeholder = "Sempre última automaticamente";
    } else {
        numInput.disabled = false;
        numInput.placeholder = "Número da pergunta";
    }

    openModal("#modalEditarPergunta");
}

function salvarEdicaoPergunta() {
    const id    = document.getElementById("editarIdPergunta").value;
    const setor = document.getElementById("selectSetorPergunta").value;
    const texto = document.getElementById("editarTextoPergunta").value.trim();
    const numero = document.getElementById("editarNumeroPergunta").value;
    const tipo = document.getElementById("editarTipoPergunta").value;

    if (!texto) return alert("O texto da pergunta é obrigatório.");

    apiPost("../../src/controller/perguntaController.php", {
        acao: "editar", id, setor, texto, numero, tipo
    }).then(res => {
        if (res.erro) return alert(res.erro);
        closeAllModals();
        carregarPerguntasSetor();
    });
}

// Bloqueio do número para perguntas de texto
document.addEventListener("DOMContentLoaded", () => {
    const novoTipo = document.getElementById("novoTipoPergunta");
    const novoNumero = document.getElementById("novoNumeroPergunta");

    const editarTipo = document.getElementById("editarTipoPergunta");
    const editarNumero = document.getElementById("editarNumeroPergunta");

    function atualizarCampos(select, input) {
        if (!select || !input) return;

        if (select.value === "0") {
            input.disabled = true;
            input.placeholder = "Sempre última automaticamente";
            input.value = "";
        } else {
            input.disabled = false;
            input.placeholder = "Número da pergunta";
        }
    }

    if (novoTipo) {
        novoTipo.addEventListener("change", () => atualizarCampos(novoTipo, novoNumero));
        atualizarCampos(novoTipo, novoNumero);
    }

    if (editarTipo) {
        editarTipo.addEventListener("change", () => atualizarCampos(editarTipo, editarNumero));
        atualizarCampos(editarTipo, editarNumero);
    }
});

/* ==========================================================
   RELATÓRIOS
   ========================================================== */

function aplicarFiltrosRelatorio() {
    const dataIni = document.getElementById("filtroDataIni")?.value || "";
    const dataFim = document.getElementById("filtroDataFim")?.value || "";
    const setor   = document.getElementById("filtroSetor")?.value || "";
    const disp    = document.getElementById("filtroDispositivo")?.value || "";

    apiPost("../../src/controller/relatorioController.php", {
        acao: "filtrar",
        dataIni,
        dataFim,
        setor,
        disp
    })
    .then(lista => {
        atualizarTabelaRelatorio(lista);
        atualizarLinksExportacao();
    })
    .catch(() => alert("Erro ao carregar relatórios."));
}

function atualizarTabelaRelatorio(lista) {
    const tbody = document.querySelector("#tabelaRelatorio tbody");
    if (!tbody) return;

    tbody.innerHTML = "";

    if (!lista || lista.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" style="text-align:center; padding:15px;">
                    Nenhum resultado encontrado.
                </td>
            </tr>
        `;
        return;
    }

    lista.forEach(l => {
        let notasFormatadas = "";
        l.notas.forEach(n => {
            notasFormatadas += `${n.numero}. ${n.texto}: ${n.nota}\n`;
        });

        tbody.innerHTML += `
            <tr>
                <td>${l.data}</td>
                <td>${l.nome_dispositivo}</td>
                <td>${l.nome_setor}</td>
                <td class="col-notas">${notasFormatadas}</td>
                <td class="col-feedback">${l.feedback ? l.feedback : "<i>(nenhum)</i>"}</td>
            </tr>
        `;
    });
}

function carregarFiltrosRelatorio() {

    // SETORES
    loadSelect(
        "../../src/controller/setorController.php",
        { acao: "listar" },
        "filtroSetor"
    );

    // DISPOSITIVOS
    apiPost("../../src/controller/dispositivoController.php", { acao: "listar" })
        .then(lista => {
            const sel = document.getElementById("filtroDispositivo");
            if (!sel) return;
            sel.innerHTML = `<option value="">Todos</option>`;
            lista.forEach(d => {
                sel.innerHTML += `<option value="${d.id_dispositivo}">${d.nome_dispositivo}</option>`;
            });
        });
}

function atualizarLinksExportacao() {
    const dataIni = document.getElementById("filtroDataIni")?.value || "";
    const dataFim = document.getElementById("filtroDataFim")?.value || "";
    const setor   = document.getElementById("filtroSetor")?.value || "";
    const disp    = document.getElementById("filtroDispositivo")?.value || "";

    const query = new URLSearchParams({
        data_inicio: dataIni,
        data_fim: dataFim,
        setor,
        dispositivo: disp
    }).toString();

    document.getElementById("btnExportExcel").href = `../../src/controller/exportExcel.php?${query}`;
    document.getElementById("btnExportPdf").href   = `../../src/controller/exportPdf.php?${query}`;
}

document.addEventListener("DOMContentLoaded", () => {
    if (document.getElementById("tabelaRelatorio")) {

        carregarFiltrosRelatorio();

        const btnFiltrar = document.getElementById("btnAplicarFiltro");
        if (btnFiltrar) btnFiltrar.addEventListener("click", aplicarFiltrosRelatorio);

        aplicarFiltrosRelatorio();
    }
});
