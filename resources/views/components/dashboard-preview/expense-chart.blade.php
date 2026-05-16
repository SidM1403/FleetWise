<div
    class="rounded-2xl border-4 border-ink bg-white p-8 shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] dark:bg-[#111111] dark:border-white transition-all hover:translate-x-1 hover:translate-y-1 hover:shadow-none duration-300">
    <div class="flex items-center justify-between mb-8">
        <h3 class="text-[10px] font-black text-ink uppercase tracking-[0.2em] dark:text-white">Revenue vs Expenses</h3>
        <span
            class="text-[10px] font-black text-ink bg-[#F7C948] px-3 py-1 border-2 border-ink shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] uppercase">Live
            Data</span>
    </div>
    <div class="h-48 relative">
        <canvas id="miniExpenseChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Wait for Chart.js to load if it hasn't already
        const initMiniChart = () => {
            if (window.Chart) {
                new Chart(document.getElementById('miniExpenseChart'), {
                    type: 'bar',
                    data: {
                        labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN'],
                        datasets: [{
                            label: 'Expenses (₹)',
                            data: [22000, 19000, 25000, 32000, 28000, 48929],
                            backgroundColor: '#F7C948',
                            borderColor: '#000000',
                            borderWidth: 2,
                            hoverBackgroundColor: '#000000',
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#000000',
                                titleFont: { family: 'Inter', size: 10, weight: 'bold' },
                                bodyFont: { family: 'Inter', size: 12, weight: 'bold' },
                                padding: 10,
                                cornerRadius: 0,
                                displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                display: false,
                                beginAtZero: true
                            },
                            x: {
                                grid: { display: false },
                                ticks: {
                                    font: { family: 'Inter', weight: '900', size: 10 },
                                    color: '#000000'
                                },
                                border: { display: false }
                            }
                        },
                        animation: {
                            duration: 2000,
                            easing: 'easeOutQuart'
                        }
                    }
                });
            } else {
                setTimeout(initMiniChart, 100);
            }
        };
        initMiniChart();
    });
</script>