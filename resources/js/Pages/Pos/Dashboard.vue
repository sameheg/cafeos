<template>
  <div class="p-4">
    <h1>POS Dashboard</h1>
    <div v-if="isInventoryEnabled">
      Stock: {{ stock }}
    </div>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';

const { props } = usePage();
const isInventoryEnabled = props.isInventoryEnabled;
const stock = props.stock ?? 0;
</script>
