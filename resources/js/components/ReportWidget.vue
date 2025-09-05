<template>
    <div>
        <div v-if="metrics.sales_per_waiter">
            <h3>Sales Per Waiter</h3>
            <ul>
                <li v-for="item in metrics.sales_per_waiter" :key="item.waiter">
                    {{ item.waiter }}: {{ item.total_sales }}
                </li>
            </ul>
        </div>
        <div v-if="metrics.table_turnover">
            <h3>Table Turnover</h3>
            <ul>
                <li v-for="item in metrics.table_turnover" :key="item.table">
                    {{ item.table }}: {{ item.orders }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            metrics: {}
        }
    },
    created() {
        if (window.Echo) {
            window.Echo.channel('report-metrics')
                .listen('ReportMetricUpdated', (e) => {
                    this.$set(this.metrics, e.metric, e.data);
                });
        }
    }
}
</script>

