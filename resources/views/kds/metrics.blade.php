<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KDS Metrics Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.prod.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div id="app">
    <canvas id="chart"></canvas>
</div>

<script>
const { createApp } = Vue;
createApp({
    data() {
        return { metrics: [] };
    },
    mounted() {
        fetch('/api/kds/metrics')
            .then(r => r.json())
            .then(data => {
                this.metrics = data.metrics;
                const ctx = document.getElementById('chart');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: this.metrics.map(m => new Date(m.created_at).toLocaleTimeString()),
                        datasets: [
                            {
                                label: 'Prep Time (s)',
                                data: this.metrics.map(m => m.prep_time_seconds),
                                borderColor: 'blue',
                                fill: false,
                            },
                            {
                                label: 'Queue Time (s)',
                                data: this.metrics.map(m => m.queue_time_seconds),
                                borderColor: 'red',
                                fill: false,
                            }
                        ]
                    }
                });
            });
    }
}).mount('#app');
</script>
</body>
</html>
