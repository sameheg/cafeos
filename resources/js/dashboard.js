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

if (window.Echo) {
    window.Echo.channel('dashboard')
        .listen('SalesUpdated', function (e) {
            updateMetric('total-sales', e.totalSales);
        })
        .listen('StockUpdated', function (e) {
            updateMetric('product-count', e.productCount);
        });
} else {
    setInterval(fetchMetrics, 10000);
}

fetchMetrics();

