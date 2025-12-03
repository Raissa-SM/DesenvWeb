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

// ======= SETORES ======= //

function carregarSetores() {
    fetch("../../src/controller/setorController.php", {
        method: "POST",
        body: new URLSearchParams({ acao: "listar" })
    })
    .then(r => r.json())
    .then(lista => {
        const tbody = document.querySelector("#tabelaSetores tbody");
        tbody.innerHTML = "";

        lista.forEach(s => {
            const classe = s.status_setor == '1' ? "" : "linha-inativa";
            
            tbody.innerHTML += `
                <tr class="${classe}">
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
            `;
        });
    });
}

function abrirModalNovoSetor() {
    document.getElementById("modalNovoSetor").classList.remove("oculto");
    document.body.classList.add("modal-aberto");
    document.body.style.overflow = "hidden";
}

function abrirModalEditar(id, nome) {
    document.getElementById("editarIdSetor").value = id;
    document.getElementById("editarNomeSetor").value = nome;
    document.getElementById("modalEditarSetor").classList.remove("oculto");
    document.body.classList.add("modal-aberto");
    document.body.style.overflow = "hidden";
}

function fecharModais() {
    document.querySelectorAll(".modal").forEach(m => m.classList.add("oculto"));
    document.body.classList.remove("modal-aberto");
    document.body.style.overflow = "auto"
}

function salvarNovoSetor() {
    const nome = document.getElementById("novoNomeSetor").value.trim();

    if (nome === "") {
        alert("O nome do setor é obrigatório.");
        return;
    }

    fetch("../../src/controller/setorController.php", {
        method: "POST",
        body: new URLSearchParams({
            acao: "adicionar",
            nome
        })
    })
    .then(r => r.json())
    .then(res => {
        if (res.erro) {
            alert(res.erro);
            return;
        }

        fecharModais();
        carregarSetores();
    });
}


function salvarEdicaoSetor() {
    const id   = document.getElementById("editarIdSetor").value;
    const nome = document.getElementById("editarNomeSetor").value.trim();

    if (nome === "") {
        alert("O nome do setor é obrigatório.");
        return;
    }

    fetch("../../src/controller/setorController.php", {
        method: "POST",
        body: new URLSearchParams({
            acao: "editar",
            id, nome
        })
    })
    .then(r => r.json())
    .then(res => {
        if (res.erro) {
            alert(res.erro);
            return;
        }

        fecharModais();
        carregarSetores();
    });
}


function alterarStatus(id, status) {
    if (status == 0) {
        if (!confirm("Desativar este setor?")) return;
    } else {
        if (!confirm("Ativar este setor novamente?")) return;
    }

    fetch("../../src/controller/setorController.php", {
        method: "POST",
        body: new URLSearchParams({
            acao: "status",
            id,
            status
        })
    })
    .then(r => r.json())
    .then(() => carregarSetores());
}


// Carrega ao abrir página
if (document.querySelector("#tabelaSetores")) carregarSetores();


// ======= DISPOSITIVOS ======= //

function carregarDispositivos() {
    fetch("../../src/controller/dispositivoController.php", {
        method: "POST",
        body: new URLSearchParams({ acao: "listar" })
    })
    .then(r => r.json())
    .then(lista => {
        const tbody = document.querySelector("#tabelaDispositivos tbody");
        tbody.innerHTML = "";

        lista.forEach(d => {
            const classe = d.status_dispositivo == '1' ? "" : "linha-inativa";

            tbody.innerHTML += `
                <tr class="${classe}">
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
            `;
        });
    });
}

function carregarSetoresSelect(idSelect) {
    fetch("../../src/controller/dispositivoController.php", {
        method: "POST",
        body: new URLSearchParams({ acao: "listarSetores" })
    })
    .then(r => r.json())
    .then(lista => {
        const select = document.getElementById(idSelect);
        select.innerHTML = "";

        lista.forEach(s => {
            select.innerHTML += `<option value="${s.id_setor}">${s.nome_setor}</option>`;
        });
    });
}

function abrirModalNovoDispositivo() {
    carregarSetoresSelect("novoSetor");
    document.getElementById("modalNovoDispositivo").classList.remove("oculto");
}

function abrirModalEditarDispositivo(id, nome, setor) {
    carregarSetoresSelect("editarSetor");
    document.getElementById("editarIdDispositivo").value = id;
    document.getElementById("editarNomeDispositivo").value = nome;

    setTimeout(() => {
        document.getElementById("editarSetor").value = setor;
    }, 100);

    document.getElementById("modalEditarDispositivo").classList.remove("oculto");
}

function salvarNovoDispositivo() {
    const nome = document.getElementById("novoNomeDispositivo").value.trim();
    const setor = document.getElementById("novoSetor").value;

    if (nome === "") {
        alert("O nome do dispositivo é obrigatório.");
        return;
    }

    if (!setor) {
        alert("Selecione um setor para o dispositivo.");
        return;
    }

    fetch("../../src/controller/dispositivoController.php", {
        method: "POST",
        body: new URLSearchParams({ acao: "adicionar", nome, setor })
    })
    .then(r => r.json())
    .then(res => {
        if (res.erro) {
            alert(res.erro);
            return;
        }

        fecharModais();
        carregarDispositivos();
    });
}


function salvarEdicaoDispositivo() {
    const id    = document.getElementById("editarIdDispositivo").value;
    const nome  = document.getElementById("editarNomeDispositivo").value.trim();
    const setor = document.getElementById("editarSetor").value;

    if (nome === "") {
        alert("O nome do dispositivo é obrigatório.");
        return;
    }

    if (!setor) {
        alert("Selecione um setor.");
        return;
    }

    fetch("../../src/controller/dispositivoController.php", {
        method: "POST",
        body: new URLSearchParams({ acao: "editar", id, nome, setor })
    })
    .then(r => r.json())
    .then(res => {
        if (res.erro) {
            alert(res.erro);
            return;
        }

        fecharModais();
        carregarDispositivos();
    });
}


function alterarStatusDispositivo(id, status) {
    if (status == 0) {
        if (!confirm("Desativar este dispositivo?")) return;
    } else {
        if (!confirm("Ativar este dispositivo novamente?")) return;
    }

    fetch("../../src/controller/dispositivoController.php", {
        method: "POST",
        body: new URLSearchParams({ acao: "status", id, status })
    })
    .then(r => r.json())
    .then(() => carregarDispositivos());
}


if (document.querySelector("#tabelaDispositivos")) carregarDispositivos();

// ================================================
//                PERGUNTAS
// ================================================

// Carregar setores no SELECT
function carregarSelectSetoresPerg() {
    fetch("../../src/controller/setorController.php", {
        method: "POST",
        body: new URLSearchParams({ acao: "listar" })
    })
    .then(r => r.json())
    .then(lista => {
        let sel = document.getElementById("selectSetorPergunta");
        sel.innerHTML = `<option value="">-- Selecione --</option>`;
        lista.forEach(s => {
            sel.innerHTML += `<option value="${s.id_setor}">${s.nome_setor}</option>`;
        });
    });
}

function atualizarBotaoNovaPergunta() {
    let setor = document.getElementById("selectSetorPergunta").value;
    let botao = document.getElementById("btnNovaPergunta");

    botao.disabled = !setor;
}

if (document.getElementById("selectSetorPergunta")) {
    carregarSelectSetoresPerg();
    addEventListener("change", atualizarBotaoNovaPergunta);
}


// Listar perguntas do setor
function carregarPerguntasSetor() {
    let id_setor = document.getElementById("selectSetorPergunta").value;
    if (!id_setor) return;

    fetch("../../src/controller/perguntaController.php", {
        method: "POST",
        body: new URLSearchParams({ acao: "listar", setor: id_setor })
    })
    .then(r => r.json())
    .then(lista => {
        let tbody = document.querySelector("#tabelaPerguntas tbody");
        tbody.innerHTML = "";

        lista.forEach(p => {
            const classe = p.status_pergunta == '1' ? "" : "linha-inativa";

            tbody.innerHTML += `
                <tr class="${classe}">
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
            `;
        });
    });
}

function alterarStatusPergunta(id, status) {

    if (status == 0) {
        if (!confirm("Desativar esta pergunta?")) return;
    } else {
        if (!confirm("Ativar esta pergunta novamente?")) return;
    }

    fetch("../../src/controller/perguntaController.php", {
        method: "POST",
        body: new URLSearchParams({
            acao: "status",
            id,
            status
        })
    })
    .then(r => r.json())
    .then(res => {
        if (res.erro) {
            alert(res.erro);
            return;
        }

        carregarPerguntasSetor();
    });
}

function proximoNumeroDisponivel() {
    let linhas = document.querySelectorAll("#tabelaPerguntas tbody tr");

    if (linhas.length === 0) return 1;

    let maior = 0;

    linhas.forEach(l => {
        let num = parseInt(l.children[0].innerText);
        if (num > maior) maior = num;
    });

    return maior + 1;
}



// Abrir modal nova
function abrirModalNovaPergunta() {
    document.getElementById("novoNumeroPergunta").value = proximoNumeroDisponivel();
    document.getElementById("modalNovaPergunta").classList.remove("oculto");
    document.body.style.overflow = "hidden";
}



// Salvar nova
function salvarNovaPergunta() {
    let setor = document.getElementById("selectSetorPergunta").value;
    let texto = document.getElementById("novoTextoPergunta").value.trim();
    let numero = document.getElementById("novoNumeroPergunta").value;
    let tipo = document.getElementById("novoTipoPergunta").value;

    if (texto === "") {
        alert("O texto da pergunta é obrigatório.");
        return;
    }

    fetch("../../src/controller/perguntaController.php", {
        method: "POST",
        body: new URLSearchParams({
            acao: "adicionar",
            setor, texto, numero, tipo
        })
    })
    .then(r => r.json())
    .then(res => {
        if (res.erro) {
            alert(res.erro);
            return;
        }

        fecharModais();
        carregarPerguntasSetor();
    });
}


// Abrir modal editar
function abrirModalEditarPergunta(id, setor, texto, numero, tipo) {
    document.getElementById("editarIdPergunta").value = id;
    document.getElementById("editarTextoPergunta").value = texto;
    document.getElementById("editarNumeroPergunta").value = numero;
    document.getElementById("editarTipoPergunta").value = tipo;

    const tipoSelect = document.getElementById("editarTipoPergunta");
    const numeroInput = document.getElementById("editarNumeroPergunta");

    // --- Se for pergunta de TEXTO, trava o número imediatamente ---
    if (tipo == 0) {
        numeroInput.disabled = true;
        numeroInput.placeholder = "Sempre última automaticamente";
    } else {
        numeroInput.disabled = false;
        numeroInput.placeholder = "Número da pergunta";
    }

    document.getElementById("modalEditarPergunta").classList.remove("oculto");
    document.body.style.overflow = "hidden";
}


// Salvar edição
function salvarEdicaoPergunta() {
    let id = document.getElementById("editarIdPergunta").value;
    let setor = document.getElementById("selectSetorPergunta").value;
    let texto = document.getElementById("editarTextoPergunta").value.trim();
    let numero = document.getElementById("editarNumeroPergunta").value;
    let tipo = document.getElementById("editarTipoPergunta").value;

    if (texto === "") {
        alert("O texto da pergunta é obrigatório.");
        return;
    }

    fetch("../../src/controller/perguntaController.php", {
        method: "POST",
        body: new URLSearchParams({
            acao: "editar",
            id, setor, texto, numero, tipo
        })
    })
    .then(r => r.json())
    .then(res => {
        if (res.erro) {
            alert(res.erro);
            return;
        }

        fecharModais();
        carregarPerguntasSetor();
    });
}


// Desativar
function desativarPergunta(id) {
    if (!confirm("Desativar essa pergunta?")) return;

    fetch("../../src/controller/perguntaController.php", {
        method: "POST",
        body: new URLSearchParams({
            acao: "desativar",
            id
        })
    })
    .then(() => carregarPerguntasSetor());
}

// ====== BLOQUEAR CAMPO "NÚMERO" QUANDO O TIPO = TEXTO (0) ======
document.addEventListener("DOMContentLoaded", () => {

    const novoTipo = document.getElementById("novoTipoPergunta");
    const novoNumero = document.getElementById("novoNumeroPergunta");

    const editarTipo = document.getElementById("editarTipoPergunta");
    const editarNumero = document.getElementById("editarNumeroPergunta");

    function atualizarCampos(tipoSelect, numeroInput) {
        if (!tipoSelect || !numeroInput) return;

        if (tipoSelect.value === "0") {
            numeroInput.disabled = true;
            numeroInput.placeholder = "Sempre última automaticamente";
            numeroInput.value = "";
        } else {
            numeroInput.disabled = false;
            numeroInput.placeholder = "Número da pergunta";
        }
    }

    // Eventos dos selects
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
   RELATÓRIOS — NOVO SISTEMA (filtros, busca e tabela)
   ========================================================== */

function aplicarFiltrosRelatorio() {
    const dataIni = document.getElementById("filtroDataIni")?.value || "";
    const dataFim = document.getElementById("filtroDataFim")?.value || "";
    const setor   = document.getElementById("filtroSetor")?.value || "";
    const disp    = document.getElementById("filtroDispositivo")?.value || "";

    fetch("../../src/controller/relatorioController.php", {
        method: "POST",
        body: new URLSearchParams({
            acao: "filtrar",
            dataIni,
            dataFim,
            setor,
            disp
        })
    })
    .then(r => r.json())
    .then(lista => {
        atualizarTabelaRelatorio(lista);
        atualizarLinksExportacao();   // <--- AQUI está o segredo
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

/* Carregar setores e dispositivos nos filtros */
function carregarFiltrosRelatorio() {

    // ---- SETORES ----
    fetch("../../src/controller/setorController.php", {
        method: "POST",
        body: new URLSearchParams({ acao: "listar" })
    })
    .then(r => r.json())
    .then(lista => {
        const sel = document.getElementById("filtroSetor");
        if (!sel) return;
        sel.innerHTML = `<option value="">Todos</option>`;
        lista.forEach(s => {
            sel.innerHTML += `<option value="${s.id_setor}">${s.nome_setor}</option>`;
        });
    });

    // ---- DISPOSITIVOS ----
    fetch("../../src/controller/dispositivoController.php", {
        method: "POST",
        body: new URLSearchParams({ acao: "listar" })
    })
    .then(r => r.json())
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
        setor: setor,
        dispositivo: disp
    }).toString();

    document.getElementById("btnExportExcel").href =
        `../../src/controller/exportExcel.php?${query}`;

    document.getElementById("btnExportPdf").href =
        `../../src/controller/exportPdf.php?${query}`;
}


/* Auto-execução apenas na página relatórios */
document.addEventListener("DOMContentLoaded", () => {
    if (document.getElementById("tabelaRelatorio")) {

        carregarFiltrosRelatorio();

        const btnFiltrar = document.getElementById("btnAplicarFiltro");
        if (btnFiltrar) btnFiltrar.addEventListener("click", aplicarFiltrosRelatorio);

        // Aplicar ao abrir a página também
        aplicarFiltrosRelatorio();
    }
});
