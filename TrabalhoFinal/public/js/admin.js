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
            tbody.innerHTML += `
                <tr>
                    <td>${s.id_setor}</td>
                    <td>${s.nome_setor}</td>
                    <td>${s.status_setor == 1 ? "Ativo" : "Inativo"}</td>
                    <td>
                        <button class="btn-small" onclick="abrirModalEditar(${s.id_setor}, '${s.nome_setor}')">Editar</button>
                        <button class="btn-small" onclick="alterarStatus(${s.id_setor}, ${s.status_setor == 1 ? 0 : 1})">
                            ${s.status_setor == 1 ? "Desativar" : "Ativar"}
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
    const nome = document.getElementById("novoNomeSetor").value;

    fetch("../../src/controller/setorController.php", {
        method: "POST",
        body: new URLSearchParams({
            acao: "adicionar",
            nome: nome
        })
    })
    .then(r => r.json())
    .then(res => {
        if (res.status) {
            fecharModais();
            carregarSetores();
        }
    });
}

function salvarEdicaoSetor() {
    const id = document.getElementById("editarIdSetor").value;
    const nome = document.getElementById("editarNomeSetor").value;

    fetch("../../src/controller/setorController.php", {
        method: "POST",
        body: new URLSearchParams({
            acao: "editar",
            id: id,
            nome: nome
        })
    })
    .then(r => r.json())
    .then(res => {
        if (res.status) {
            fecharModais();
            carregarSetores();
        }
    });
}

function alterarStatus(id, status) {
    fetch("../../src/controller/setorController.php", {
        method: "POST",
        body: new URLSearchParams({
            acao: "status",
            id: id,
            status: status
        })
    })
    .then(r => r.json())
    .then(res => carregarSetores());
}

// Carrega ao abrir página
if (document.querySelector("#tabelaSetores")) carregarSetores();
