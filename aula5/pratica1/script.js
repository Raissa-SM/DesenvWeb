var conta = '';

function apagar() {
    conta = '';
    atualizarVisor();
}

function backspace() {
    conta = conta.slice(0,-1);
    atualizarVisor();
}

function numero(num) {
    conta += num;
    atualizarVisor(); 
}

var oper = 0;
function operador(op) {
    if (oper > 0) {
        calcular();
    }
    oper++;
    conta += op;
    atualizarVisor(); 
}

function mudaCor() {
    let tela = document.getElementById('tela');
    let valor = Number(conta);

    if (valor > 0) {
        tela.style.backgroundColor = "green";
    } else if (valor === 0) {
        tela.style.backgroundColor = "gray";
    } else {
        tela.style.backgroundColor = "red";
    }
}


function calcular(){
    try {
        conta = eval(conta).toString();
        oper = 0;
        mudaCor();
        atualizarVisor();
    } catch {
        conta = "Erro";
        atualizarVisor();
    }
}

function atualizarVisor() {
    let tela = document.getElementById('tela');
    tela.value = conta;
}