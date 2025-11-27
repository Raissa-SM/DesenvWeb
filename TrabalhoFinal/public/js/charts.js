document.addEventListener("DOMContentLoaded", () => {
    const data = window.DASHBOARD_DATA || {};
    if (!data) return;

    // ---------- chart Ultimos 7 dias ----------
    const ctx7 = document.getElementById("chartUlt7Dias");
    if (ctx7) {
        const ult7 = data.ult7dias || {};
        // garantir 7 dias (preencher zeros quando necessário)
        const dias = [];
        const valores = [];
        // gera array de últimos 7 dias (YYYY-MM-DD)
        for (let i = 6; i >= 0; i--) {
            const d = new Date();
            d.setDate(d.getDate() - i);
            const key = d.toISOString().slice(0,10);
            dias.push(key);
            valores.push(Number(ult7[key] || 0));
        }

        new Chart(ctx7.getContext("2d"), {
            type: 'line',
            data: {
                labels: dias,
                datasets: [{
                    label: 'Avaliações (últimos 7 dias)',
                    data: valores,
                    borderColor: '#009898',
                    backgroundColor: 'rgba(0,152,152,0.08)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { ticks: { color: '#444' } },
                    y: { beginAtZero: true, ticks: { color: '#444' } }
                }
            }
        });
    }

    // ---------- chart Notas (Distribuição) ----------
    const ctxNotas = document.getElementById("chartNotas");
    if (ctxNotas) {
        const dist = data.distNotas || {};
        // garantir rótulos 0..10
        const labels = Array.from({length:11}, (_,i) => String(i));
        const counts = labels.map(l => Number(dist[l] || 0));

        new Chart(ctxNotas.getContext("2d"), {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Contagem por nota (30 dias)',
                    data: counts,
                    backgroundColor: labels.map(n => {
                        // aproxima as cores do seu esquema
                        const v = Number(n);
                        if (v <= 2) return '#d32f2f';
                        if (v <= 4) return '#f57c00';
                        if (v <= 6) return '#fbc02d';
                        if (v <= 8) return '#8bc34a';
                        return '#2e7d32';
                    })
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { ticks: { color: '#444' } },
                    y: { beginAtZero: true, ticks: { color: '#444' } }
                }
            }
        });
    }

    // ---------- chart Por Dispositivo ----------
    const ctxDisp = document.getElementById("chartPorDispositivo");
    if (ctxDisp) {
        const arr = data.porDispositivo || [];
        const labels = arr.map(r => r.nome_dispositivo);
        const counts = arr.map(r => Number(r.cnt));
        new Chart(ctxDisp.getContext("2d"), {
            type: 'pie',
            data: {
                labels,
                datasets: [{
                    data: counts,
                    backgroundColor: labels.map((_,i) => {
                        // gera cores suaves
                        const palette = ['#009898','#43a047','#8bc34a','#fbc02d','#fb8c00','#e53935','#7b1fa2','#1976d2','#00acc1','#455a64'];
                        return palette[i % palette.length];
                    })
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }

});
