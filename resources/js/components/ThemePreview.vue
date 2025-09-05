<template>
  <div class="theme-preview" :style="previewStyle">
    <slot>Theme Preview</slot>
  </div>
</template>

<script>
export default {
  props: {
    primary: { type: String, default: '#ffffff' },
    secondary: { type: String, default: '#000000' },
    layout: { type: String, default: 'light' }
  },
  computed: {
    previewStyle() {
      return {
        backgroundColor: this.primary,
        color: this.layout === 'dark' ? '#fff' : '#000',
        padding: '1rem',
        border: `2px solid ${this.secondary}`
      };
    }
  }
};
</script>

<style scoped>
.theme-preview {
  margin-top: 1rem;
}
</style>
