const source = new EventSource('/api/analytics/realtime');

source.onmessage = (event) => {
    const data = JSON.parse(event.data);
    const el = document.getElementById('realtime-sales');
    if (el) {
        el.textContent = `Sales: ${data.sales} | Forecast: ${data.forecast}`;
    }
};
