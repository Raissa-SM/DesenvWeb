function iniciarAvaliacao() {
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
            window.location.href = "inicio.html";
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

        try {
            const response = await fetch("../src/controller/AvaliacaoController.php", {
                method: "POST",
                body: dados,
            });

            if (response.ok) {
                window.location.href = "obrigado.html";
            } else {
                alert("Erro ao enviar avaliação!");
            }
        } catch (err) {
            console.error(err);
            alert("Falha na comunicação com o servidor.");
        }
    });
}

function obigadoTimeout() {
    setTimeout(() => {
        window.location.href = "inicio.html";
    }, 8000);
}
