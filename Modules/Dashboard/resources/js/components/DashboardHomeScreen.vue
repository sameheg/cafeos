<template>
  <div>
    <alert-banner v-if="alert" :message="alert" />
    <canvas id="kpi-chart" aria-label="KPIs chart" />
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import Chart from 'chart.js/auto';
const alert = ref('');

onMounted(async () => {
  const res = await fetch('/api/v1/dashboard/kpis?time_window=1h');
  if (res.ok) {
    const json = await res.json();
    new Chart(document.getElementById('kpi-chart'), {
      type: 'bar',
      data: {
        labels: Object.keys(json.data),
        datasets: [{ label: 'Value', data: Object.values(json.data) }]
      }
    });
  }
});
</script>
