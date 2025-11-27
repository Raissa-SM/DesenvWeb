/* ============================================================
   GRÁFICOS DO DASHBOARD ADMINISTRATIVO
   Requer: Chart.js (CDN já incluída no footer)
   Dados recebidos de: window.DASHBOARD_DATA
   ============================================================ */

document.addEventListener("DOMContentLoaded", function () {

    if (!window.DASHBOARD_DATA) {
        console.error("Nenhum dado recebido para os gráficos!");
        return;
    }

    const {
        ult7dias,
        distNotas,
        porDispositivo,
        mediasPorSetor
    } = window.DASHBOARD_DATA;

    /* ------------------------------------------------------------
       CONFIGURAÇÃO DE CORES PADRÃO
       ------------------------------------------------------------ */
    const corPrincipal = "#009898";
    const corSecundaria = "#00b3b3";
    const corFundo = "rgba(0, 152, 152, 0.15)";

    const gridColor = "rgba(0,0,0,0.10)";
    const labelColor = "#333";

    Chart.defaults.color = labelColor;
    Chart.defaults.borderColor = gridColor;



    /* ------------------------------------------------------------
       GRÁFICO 1 – Avaliações nos últimos 7 dias
       ------------------------------------------------------------ */
    const ctx7dias = document.getElementById("chartUlt7Dias");
    if (ctx7dias) {
        new Chart(ctx7dias, {
            type: "line",
            data: {
                labels: Object.keys(ult7dias),
                datasets: [{
                    label: "Avaliações",
                    data: Object.values(ult7dias),
                    borderColor: corPrincipal,
                    backgroundColor: corFundo,
                    fill: true,
                    tension: 0.35,
                    borderWidth: 2.5,
                    pointRadius: 4,
                    pointBackgroundColor: corPrincipal,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }



    /* ------------------------------------------------------------
       GRÁFICO 2 – Distribuição de notas (0 a 10)
       ------------------------------------------------------------ */
    const ctxNotas = document.getElementById("chartNotas");
    if (ctxNotas) {
        new Chart(ctxNotas, {
            type: "bar",
            data: {
                labels: Object.keys(distNotas),
                datasets: [{
                    label: "Quantidade",
                    data: Object.values(distNotas),
                    backgroundColor: corPrincipal,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }



    /* ------------------------------------------------------------
       GRÁFICO 3 – Top dispositivos avaliados
       ------------------------------------------------------------ */
    const ctxDisp = document.getElementById("chartPorDispositivo");
    if (ctxDisp) {
        const nomes = porDispositivo.map(d => d.nome_dispositivo);
        const qtd = porDispositivo.map(d => d.cnt);

        new Chart(ctxDisp, {
            type: "bar",
            data: {
                labels: nomes,
                datasets: [{
                    label: "Avaliações",
                    data: qtd,
                    backgroundColor: corSecundaria,
                    borderRadius: 6
                }]
            },
            options: {
                indexAxis: "y", // gráfico horizontal
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { beginAtZero: true }
                }
            }
        });
    }



    /* ------------------------------------------------------------
       GRÁFICO 4 – Média por setor (opcional)
       Pode ser ativado caso queira no futuro.
       ------------------------------------------------------------ */
    const ctxSetor = document.getElementById("chartPorSetor");
    if (ctxSetor && mediasPorSetor.length > 0) {

        const setores = mediasPorSetor.map(s => s.nome_setor);
        const medias = mediasPorSetor.map(s => s.media);

        new Chart(ctxSetor, {
            type: "bar",
            data: {
                labels: setores,
                datasets: [{
                    label: "Média",
                    data: medias,
                    backgroundColor: corPrincipal,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 10
                    }
                }
            }
        });
    }

    if (window.DASHBOARD_DATA.participacaoSetor) {
        const ctx = document.getElementById("chartPizzaSetor");

        new Chart(ctx, {
            type: "pie",
            data: {
                labels: window.DASHBOARD_DATA.participacaoSetor.map(s => s.nome_setor),
                datasets: [{
                    data: window.DASHBOARD_DATA.participacaoSetor.map(s => s.total)
                }]
            },
            options: {
                plugins: {
                    legend: { position: "bottom" }
                }
            }
        });
    }


});
