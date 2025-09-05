<template>
  <div class="settings">
    <h2>{{ t('settings.title') }}</h2>
    <label>
      {{ t('settings.language') }}
      <select v-model="prefs.language">
        <option value="en">English</option>
        <option value="ar">العربية</option>
      </select>
    </label>
    <label>
      {{ t('settings.color') }}
      <select v-model="prefs.color">
        <option value="light">{{ t('settings.light') }}</option>
        <option value="dark">{{ t('settings.dark') }}</option>
      </select>
    </label>
    <label>
      {{ t('settings.layout') }}
      <select v-model="prefs.layout">
        <option value="grid">{{ t('settings.grid') }}</option>
        <option value="list">{{ t('settings.list') }}</option>
      </select>
    </label>
    <button @click="save">{{ t('settings.save') }}</button>
  </div>
</template>

<script>
import { loadPreferences, savePreferences } from './userPreferences'

export default {
  name: 'PosSettings',
  data () {
    return {
      prefs: loadPreferences()
    }
  },
  methods: {
    t (key) {
      return (window.i18n && window.i18n[key]) || key
    },
    save () {
      savePreferences(this.prefs)
      this.$emit('updated', this.prefs)
    }
  }
}
</script>

<style scoped>
.settings {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}
</style>
