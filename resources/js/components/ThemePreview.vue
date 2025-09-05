<template>
  <div class="theme-preview" :style="previewStyle">
    <slot>Theme Preview</slot>
  </div>
</template>

<script>
export default {
  props: {
    primary: { type: String, default: '#ffffff' },
    layout: { type: String, default: 'light' }
  },
  computed: {
    previewStyle() {
      return {
        backgroundColor: this.primary,
        color: this.layout === 'dark' ? '#fff' : '#000',
        padding: '1rem',
        border: '1px solid #ccc'
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
