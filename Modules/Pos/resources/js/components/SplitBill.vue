<template>
  <form @submit.prevent="submit">
    <input v-model="orderId" placeholder="Order ID" />
    <input v-model.number="parts" placeholder="Parts" />
    <button type="submit">Split</button>
  </form>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const orderId = ref('');
const parts = ref(2);

function submit() {
  axios.post(`/waiter/orders/${orderId.value}/split`, { parts: parts.value })
    .then(response => alert(response.data.message));
}
</script>
