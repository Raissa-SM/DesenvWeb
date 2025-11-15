const formDispositivo = document.getElementById("formDispositivo");

if (formDispositivo) {
    formDispositivo.addEventListener("click", async (e) => {
        if (e.target.tagName === "BUTTON") {
            e.preventDefault();

            const id_dispositivo = e.target.value;
            const dados = new FormData();
            dados.append("acao", "definirDispositivo");
            dados.append("id_dispositivo", id_dispositivo);

            try {
                const response = await fetch("../src/db.php", {
                    method: "POST",
                    body: dados,
                });

                const result = await response.json();

                if (result.status === "ok") {
                    window.location.reload();
                } else {
                    alert(result.erro || "Erro ao definir dispositivo!");
                }
            } catch (err) {
                console.error(err);
                alert("Falha de comunicação com o servidor.");
            }
        }
    });
}

function iniciarAvaliacao() {
    // === TIMEOUT DE INATIVIDADE ===
    let timeoutInatividade;

    function resetarTimeout() {
        clearTimeout(timeoutInatividade);
        timeoutInatividade = setTimeout(() => {
            window.location.href = "inicio.php";
        }, 60000);
    }

    // Reinicia o timer ao detectar atividade
    document.addEventListener("mousemove", resetarTimeout);
    document.addEventListener("mousedown", resetarTimeout);
    document.addEventListener("touchstart", resetarTimeout);
    document.addEventListener("keydown", resetarTimeout);

    resetarTimeout();

    const perguntas = document.querySelectorAll(".pergunta");
    const btnVoltar = document.getElementById("btnVoltar");
    const btnSubmit = document.getElementById("btnSubmit");
    const form = document.getElementById("formAvaliacao");

    let indiceAtual = 0;

    // Mostra apenas a primeira pergunta
    perguntas[0].classList.remove("oculto");

    // Adiciona evento a cada botão de resposta
    document.querySelectorAll(".btnResposta").forEach(btn => {
        btn.addEventListener("click", () => {
            const idPergunta = btn.dataset.idpergunta;
            const nota = btn.value;

            // cria/atualiza input hidden com nome = respostas[id_pergunta]
            let hidden = form.querySelector(`input[name="respostas[${idPergunta}]"]`);
            if (!hidden) {
                hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = `respostas[${idPergunta}]`;
                form.appendChild(hidden);
            }
            hidden.value = nota;

            const perguntaAtual = btn.closest(".pergunta");
            const indexAtual = parseInt(perguntaAtual.dataset.index);
            mostrarProxima(indexAtual);
        });
    });

    function mostrarProxima(indexAtual) {
        // Remove a pergunta atual
        perguntas[indexAtual].classList.add("oculto");

        // Verifica se existe próxima pergunta
        if (indexAtual + 1 < perguntas.length) {
            perguntas[indexAtual + 1].classList.remove("oculto");
            indiceAtual = indexAtual + 1;
            
            // Se for a última, mostra o botão
            if (indiceAtual === perguntas.length - 1) {
                btnSubmit.classList.remove("oculto");
            }

        }
    }

    btnVoltar.addEventListener("click", (event) => {
        event.preventDefault();
        mostrarAnterior();
    });

    function mostrarAnterior() {
        if (indiceAtual === 0) {
            //se for a primeira volta pro inicio
            window.location.href = "inicio.php";
        }
        else {
            perguntas[indiceAtual].classList.add("oculto");
            perguntas[indiceAtual - 1].classList.remove("oculto");
            // Se for a última, tira o botão
            if (indiceAtual === perguntas.length - 1) {
                btnSubmit.classList.add("oculto");
            }
            indiceAtual--;
        }
    }

    form.addEventListener("submit", async (e) => {
        e.preventDefault(); // evita o submit normal

        const dados = new FormData(form); // pega todos os campos do form
        dados.append("acao", "salvarAvaliacao");
        
        try {
            const response = await fetch("../src/db.php", {
                method: "POST",
                body: dados,
            });

            const result = await response.json();

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

function obigadoTimeout() {
    setTimeout(() => {
        window.location.href = "inicio.php";
    }, 8000);
}
