<template>
  <div class="space-y-4 text-center">
    <p>{{ t('hardware_instructions') }}</p>
    <div class="space-x-2">
      <button @click="start('drive_thru')">{{ t('drive_thru') }}</button>
      <button @click="start('takeaway')">{{ t('takeaway') }}</button>
    </div>
    <div v-if="queueNumber" class="mt-4">
      <h2>{{ t('queue_number') }}: {{ queueNumber }}</h2>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({ translations: Object });
const queueNumber = ref(null);

function t(key) {
  return props.translations[key] || key;
}

function start(type) {
  fetch('/api/kiosk/order', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-Requested-With': 'XMLHttpRequest',
    },
    body: JSON.stringify({ total: 0, order_type: type }),
  })
    .then((r) => r.json())
    .then((data) => {
      queueNumber.value = data.queue_number;
    });
}
</script>
