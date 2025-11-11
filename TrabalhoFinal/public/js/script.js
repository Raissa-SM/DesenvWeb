function iniciarAvaliacao() {
    const perguntas = document.querySelectorAll(".pergunta");
    const btnVoltar = document.getElementById("btnVoltar");
    const btnSubmit = document.getElementById("btnSubmit");

    let indiceAtual = 0;

    // Esconde todas e mostra apenas a primeira pergunta
    perguntas.forEach((p, i) => {
        if (i === 0) {
            p.classList.remove("oculto");
        }
    });

    // Adiciona evento a cada botão de resposta
    document.querySelectorAll(".btnResposta").forEach(btn => {
        btn.addEventListener("click", () => {
            const index = parseInt(btn.dataset.index);
            mostrarProxima(index);
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
}

function obigadoTimeout() {
    setTimeout(() => {
        window.location.href = "inicio.html";
    }, 8000);
}
