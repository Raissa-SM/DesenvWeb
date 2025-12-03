/* =====================================================
   FUNÇÕES UTILITÁRIAS GERAIS DO TABLET
   ===================================================== */

// Mostrar elemento (overlay, modal etc.)
function showElement(selector) {
    const el = document.querySelector(selector);
    if (el) el.classList.remove("oculto");
}

// Esconder elemento
function hideElement(selector) {
    const el = document.querySelector(selector);
    if (el) el.classList.add("oculto");
}

// Fetch POST genérico
async function post(url, formData) {
    const response = await fetch(url, { method: "POST", body: formData });
    return response.json();
}

// Criar ou atualizar input hidden
function setHiddenInput(form, name, value) {
    let hidden = form.querySelector(`input[name="${name}"]`);
    if (!hidden) {
        hidden = document.createElement("input");
        hidden.type = "hidden";
        hidden.name = name;
        form.appendChild(hidden);
    }
    hidden.value = value;
}

// Timer genérico de inatividade (60s)
function startInactivityTimer(callback, tempo = 60000) {
    let timeout;
    const reset = () => {
        clearTimeout(timeout);
        timeout = setTimeout(callback, tempo);
    };

    ["mousemove", "mousedown", "touchstart", "keydown"]
        .forEach(ev => document.addEventListener(ev, reset));

    reset();
}


/* =====================================================
   OVERLAY DE DISPOSITIVO
   ===================================================== */

if (typeof temDispositivoSelecionado !== "undefined" && !temDispositivoSelecionado) {
    showElement("#overlayDispositivo");
}


/* =====================================================
   LOGIN DO ADMIN E DO TABLET
   ===================================================== */

const overlayLogin = document.getElementById("overlayLogin");
const formLoginTablet = document.getElementById("formLoginTablet");
const formLoginAdmin = document.getElementById("formLoginAdmin");

// Abrir modal
document.getElementById("btnAdmin")?.addEventListener("click", () => {
    showElement("#overlayLogin");
});

// Fechar modal
document.getElementById("fecharLogin")?.addEventListener("click", () => {
    hideElement("#overlayLogin");
});

// Login tablet
formLoginTablet?.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dados = new FormData();
    dados.append("acao", "loginTablet");
    dados.append("senha", document.getElementById("senhaTablet").value);

    try {
        const result = await post("../../src/controller/loginController.php", dados);

        if (result.status === "ok") {
            hideElement("#overlayLogin");
            showElement("#overlayDispositivo");
        } else {
            alert("Senha incorreta!");
        }

    } catch (err) {
        console.error(err);
        alert("Erro de comunicação.");
    }
});

// Login admin
formLoginAdmin?.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dados = new FormData();
    dados.append("acao", "loginAdmin");
    dados.append("senha", document.getElementById("senhaAdmin").value);

    try {
        const result = await post("../../src/controller/loginController.php", dados);

        if (result.status === "ok") {
            hideElement("#overlayLogin");
            showElement("#overlayDispositivo");
        } else {
            alert("Senha incorreta!");
        }

    } catch (err) {
        console.error(err);
        alert("Erro de comunicação.");
    }
});


/* =====================================================
   SELEÇÃO DO DISPOSITIVO
   ===================================================== */

const formDispositivo = document.getElementById("formDispositivo");

formDispositivo?.addEventListener("click", async (e) => {
    if (e.target.tagName !== "BUTTON") return;

    e.preventDefault();
    const id = e.target.value;

    const dados = new FormData();
    dados.append("acao", "definirDispositivo");
    dados.append("id_dispositivo", id);

    try {
        const result = await post("../../src/controller/dispositivoController.php", dados);

        if (result.status === "ok") {
            window.location.reload();
        } else {
            alert(result.erro || "Erro ao definir dispositivo!");
        }

    } catch (err) {
        console.error(err);
        alert("Falha de comunicação com o servidor.");
    }
});


/* =====================================================
   AVALIAÇÃO — PASSO A PASSO DAS PERGUNTAS
   ===================================================== */

function iniciarAvaliacao() {

    // Timeout de inatividade (60s)
    startInactivityTimer(() => window.location.href = "inicio.php");

    const perguntas = document.querySelectorAll(".pergunta");
    const form = document.getElementById("formAvaliacao");
    let indiceAtual = 0;

    perguntas[0].classList.remove("oculto");

    // Clique nas respostas
    document.querySelectorAll(".btnResposta").forEach(btn => {

        btn.addEventListener("click", () => {
            const id = btn.dataset.idpergunta;
            const nota = btn.value;

            setHiddenInput(form, `respostas[${id}]`, nota);

            mostrarProxima(btn.closest(".pergunta").dataset.index);
        });
    });

    // Próxima pergunta
    function mostrarProxima(i) {
        const index = parseInt(i);
        perguntas[index].classList.add("oculto");

        if (index + 1 < perguntas.length) {
            perguntas[index + 1].classList.remove("oculto");
            indiceAtual = index + 1;

            if (indiceAtual === perguntas.length - 1) {
                document.getElementById("btnSubmit").classList.remove("oculto");
            }
        }
    }

    // Voltar pergunta
    document.getElementById("btnVoltar").addEventListener("click", (ev) => {
        ev.preventDefault();

        if (indiceAtual === 0) return window.location.href = "inicio.php";

        perguntas[indiceAtual].classList.add("oculto");
        perguntas[indiceAtual - 1].classList.remove("oculto");

        if (indiceAtual === perguntas.length - 1) {
            document.getElementById("btnSubmit").classList.add("oculto");
        }

        indiceAtual--;
    });

    // Enviar avaliação
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const dados = new FormData(form);
        dados.append("acao", "salvarAvaliacao");

        try {
            const result = await post("../../src/controller/avaliacaoController.php", dados);

            if (result.status === "ok") {
                window.location.href = "obrigado.html";
            } else {
                alert(result.erro || "Erro ao enviar avaliação!");
            }

        } catch (err) {
            console.error(err);
            alert("Falha na comunicação com o servidor.");
        }
    });
}


/* =====================================================
   PÁGINA DE OBRIGADO — TIMEOUT
   ===================================================== */

function obigadoTimeout() {
    setTimeout(() => {
        window.location.href = "inicio.php";
    }, 8000);
}
