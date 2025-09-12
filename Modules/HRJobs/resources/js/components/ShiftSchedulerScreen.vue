<template>
  <div>
    <Calendar v-if="loaded" :events="shifts" />
    <p v-else>Loading shifts...</p>
    <EmployeeSelect v-if="employees.length" />
    <p v-else>No employees</p>
    <p v-if="error" class="text-red-500">Failed to save shift</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
const shifts = ref([])
const employees = ref([])
const loaded = ref(false)
const error = ref(false)

onMounted(async () => {
  loaded.value = true
})
</script>

