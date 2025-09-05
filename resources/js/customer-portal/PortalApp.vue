<template>
  <div>
    <h1>Loyalty Points: {{ points }}</h1>
    <h2>Invoices</h2>
    <ul>
      <li v-for="order in orders" :key="order.id">
        {{ order.invoice_no }} - {{ order.final_total }}
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      points: 0,
      orders: []
    };
  },
  created() {
    const headers = this.authHeader();
    axios.get('/api/customer/points', headers).then(r => {
      this.points = r.data.points;
    });
    axios.get('/api/customer/orders', headers).then(r => {
      this.orders = r.data.orders;
    });
  },
  methods: {
    authHeader() {
      const token = localStorage.getItem('customerToken');
      return { headers: { Authorization: `Bearer ${token}` } };
    }
  }
};
</script>
