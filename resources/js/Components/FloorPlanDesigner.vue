<template>
  <div class="floor-plan" :dir="isRtl ? 'rtl' : 'ltr'">
    <div
      v-for="table in tables"
      :key="table.id"
      class="table"
      draggable="true"
      @dragstart="dragStart(table)"
      @dragover.prevent
      @drop="drop(table)"
    >
      {{ table.name }}
    </div>
  </div>
</template>

<script setup>
import { reactive, computed } from 'vue';
import { useI18n } from 'vue-i18n';

const { locale } = useI18n();
const isRtl = computed(() => locale.value === 'ar');

const tables = reactive([
  { id: 1, name: 'A' },
  { id: 2, name: 'B' },
  { id: 3, name: 'C' },
]);

let dragged = null;

function dragStart(table) {
  dragged = table;
}

function drop(target) {
  const from = tables.indexOf(dragged);
  const to = tables.indexOf(target);
  tables.splice(from, 1);
  tables.splice(to, 0, dragged);
}
</script>

<style scoped>
.floor-plan {
  display: flex;
  gap: 1rem;
}

.table {
  padding: 1rem;
  background: #e5e7eb;
  cursor: move;
  user-select: none;
}
</style>
