<template>
  <div>
    <textarea v-model="content" placeholder="Template..." />
    <div class="preview" v-html="content" />
    <button @click="send" :disabled="loading">Send</button>
  </div>
</template>
<script setup>
import { ref } from 'vue'
const content = ref('')
const loading = ref(false)
function send() {
  loading.value = true
  // TODO: implement API call
  loading.value = false
}
</script>
