// Preencher inputs com valores aleatórios entre 0 e 10 (uma casa decimal)
document.querySelectorAll("tbody input").forEach(input => {
    input.value = (Math.random() * 10).toFixed(1);
});

let mediaNotasAtiva = false;
let mediaAlunosAtiva = false;

// Função para calcular média das colunas
function toggleMediaNotas() {
    const tabela = document.getElementById("tabela");
    const tbody = tabela.querySelector("tbody");

    if (mediaNotasAtiva) {
        tbody.deleteRow(tbody.rows.length - 1); // remove última linha (médias)
        mediaNotasAtiva = false;
        return;
    }

    const row = tbody.insertRow();
    row.insertCell().innerText = "Média Notas";

    for (let col = 1; col <= 9; col++) {
        let soma = 0;
        let count = 0;
        for (let r = 0; r < tbody.rows.length - 1; r++) {
            const input = tbody.rows[r].cells[col].querySelector("input");
            if (input) {
                const val = parseFloat(input.value);
                if (!isNaN(val)) {
                    soma += val;
                    count++;
                }
            }
        }
        const media = (soma / count).toFixed(1);
        row.insertCell().innerText = media;
    }

    // se a coluna de médias já existe, adicionar "-" no fim
    if (mediaAlunosAtiva) {
        row.insertCell().innerText = "-";
    }

    mediaNotasAtiva = true;
}

// Função para calcular média das linhas
function toggleMediaAlunos() {
    const tabela = document.getElementById("tabela");
    const tbody = tabela.querySelector("tbody");
    const header = tabela.querySelector("thead tr:last-child");

    if (mediaAlunosAtiva) {
        // remover última célula do cabeçalho
        header.deleteCell(header.cells.length - 1);

        // remover última célula de todas as linhas (inclusive linha de médias de notas se existir)
        for (let r = 0; r < tbody.rows.length; r++) {
            tbody.rows[r].deleteCell(tbody.rows[r].cells.length - 1);
        }

        mediaAlunosAtiva = false;
        return;
    }

    // adicionar cabeçalho
    header.insertCell().innerText = "Média";

    // calcular médias
    for (let r = 0; r < tbody.rows.length; r++) {
        // se for a linha de médias (última linha) e já existe, apenas insere "-"
        if (mediaNotasAtiva && r === tbody.rows.length - 1) {
            tbody.rows[r].insertCell().innerText = "-";
            continue;
        }

        let soma = 0;
        let count = 0;
        for (let c = 1; c <= 9; c++) {
            const input = tbody.rows[r].cells[c].querySelector("input");
            if (input) {
                const val = parseFloat(input.value);
                if (!isNaN(val)) {
                    soma += val;
                    count++;
                }
            }
        }
        const media = (count > 0 ? (soma / count).toFixed(1) : "-");
        tbody.rows[r].insertCell().innerText = media;
    }

    mediaAlunosAtiva = true;
}
