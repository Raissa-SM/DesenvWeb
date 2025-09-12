// Preenchi as notas com números aleatórios para não ter que preencher pra testar

document.querySelectorAll("tbody input").forEach(input => {
    input.value = (Math.random() * 10).toFixed(1);
});

//Se uma nota for alterada e a coluna/linha estiver ativa deve ser tirada e colocada novamente para recalcular a média

let mediaNotasAtiva = false;
let mediaAlunosAtiva = false;

// Funções para calcular as médias e adicionar/remover a coluna/linha no final da tabela

function addMediaNotas() {
    const tabela = document.getElementById("tabela");
    const tbody = tabela.querySelector("tbody");

    if (mediaNotasAtiva) {
        tbody.deleteRow(tbody.rows.length - 1);
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
                if (Number.isFinite(val)) {
                    soma += val;
                    count++;
                }
            }
        }
        const media = (soma / count).toFixed(1);
        row.insertCell().innerText = media;
    }

    if (mediaAlunosAtiva) {
        row.insertCell().innerText = "-";
    }

    mediaNotasAtiva = true;
}

function addMediaAlunos() {
    const tabela = document.getElementById("tabela");
    const tbody = tabela.querySelector("tbody");
    const header = tabela.querySelector("thead tr:last-child");

    if (mediaAlunosAtiva) {
        
        header.deleteCell(header.cells.length - 1);

        for (let r = 0; r < tbody.rows.length; r++) {
            tbody.rows[r].deleteCell(tbody.rows[r].cells.length - 1);
        }

        mediaAlunosAtiva = false;
        return;
    }

    header.insertCell().innerText = "Média";

    for (let r = 0; r < tbody.rows.length; r++) {
        
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
                if (Number.isFinite(val)) {
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
