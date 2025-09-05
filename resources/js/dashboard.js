document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('dashboard-widgets');
    if (!container || typeof Sortable === 'undefined') {
        return;
    }

    new Sortable(container, {
        animation: 150,
        onEnd: () => {
            const order = Array.from(container.children).map(child => child.getAttribute('data-widget'));
            fetch('/dashboard/widgets-order', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ widgets: order })
            });
        }
    });
});
function updateMetric(id, value) {
    var el = document.getElementById(id);
    if (el) {
        el.textContent = value;
    }
}

function fetchMetrics() {
    if (typeof axios === 'undefined') {
        return;
    }
    axios.get('/dashboard/metrics').then(function (response) {
        var data = response.data;
        updateMetric('total-sales', data.totalSales);
        updateMetric('total-purchases', data.totalPurchases);
        updateMetric('customer-count', data.customerCount);
        updateMetric('product-count', data.productCount);
    });
}

var salesTrendChartInstance = null;
var topItemsChartInstance = null;

function renderSalesTrend(data) {
    var ctx = document.getElementById('sales-trend-chart');
    if (!ctx || typeof Chart === 'undefined') {
        return;
    }
    if (salesTrendChartInstance) {
        salesTrendChartInstance.destroy();
    }
    salesTrendChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: data.datasets,
        },
    });
}

function renderTopItems(data) {
    var ctx = document.getElementById('top-items-chart');
    if (!ctx || typeof Chart === 'undefined') {
        return;
    }
    if (topItemsChartInstance) {
        topItemsChartInstance.destroy();
    }
    topItemsChartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.labels,
            datasets: data.datasets,
        },
    });
}

function fetchCharts() {
    if (typeof axios === 'undefined') {
        return;
    }
    axios
        .post('/graphql', {
            query:
                'query ($limit: Int) {\n' +
                '  salesTrend { labels datasets { label data } }\n' +
                '  topItems(limit: $limit) { labels datasets { label data } }\n' +
                '}',
            variables: { limit: 5 },
        })
        .then(function (response) {
            var charts = response.data.data;
            if (charts && charts.salesTrend) {
                renderSalesTrend(charts.salesTrend);
            }
            if (charts && charts.topItems) {
                renderTopItems(charts.topItems);
            }
        });
}

if (window.Echo) {
    window.Echo.channel('dashboard')
        .listen('SalesUpdated', function (e) {
            updateMetric('total-sales', e.totalSales);
            fetchCharts();
        })
        .listen('StockUpdated', function (e) {
            updateMetric('product-count', e.productCount);
            fetchCharts();
        });
} else {
    setInterval(function () {
        fetchMetrics();
        fetchCharts();
    }, 10000);
}

fetchMetrics();
fetchCharts();

