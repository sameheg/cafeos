<template>
  <form @submit.prevent="submit">
    <input v-model="orderId" placeholder="Order ID" />
    <input v-model="tableId" placeholder="Table ID" />
    <button type="submit">Move</button>
  </form>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const orderId = ref('');
const tableId = ref('');

function submit() {
  axios.post(`/waiter/orders/${orderId.value}/move`, { table_id: tableId.value })
    .then(response => alert(response.data.message));
}
</script>
