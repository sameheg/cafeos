<template>
  <div class="table-view">
    <div class="navigation">
      <button class="nav-btn" @click="prev" aria-label="Previous tables">&lt;</button>
      <button class="nav-btn" @click="next" aria-label="Next tables">&gt;</button>
    </div>
    <ul class="tables" @touchstart="handleTouchStart" @touchend="handleTouchEnd">
      <li v-for="table in tables" :key="table.id">
        <button class="table-btn" @click="$emit('select', table)" :aria-label="`Table ${table.name}`">
          {{ table.name }}
        </button>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'TableView',
  props: {
    tables: { type: Array, default: () => [] }
  },
  data () {
    return { startX: 0 }
  },
  methods: {
    prev () {
      this.$emit('prev')
    },
    next () {
      this.$emit('next')
    },
    handleTouchStart (e) {
      if (e.changedTouches && e.changedTouches.length) {
        this.startX = e.changedTouches[0].screenX
      }
    },
    handleTouchEnd (e) {
      if (!e.changedTouches || !e.changedTouches.length) return
      const endX = e.changedTouches[0].screenX
      if (endX - this.startX > 40) {
        this.prev()
      } else if (this.startX - endX > 40) {
        this.next()
      }
    }
  }
}
</script>

<style scoped>
.table-view {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}
.navigation {
  display: flex;
  justify-content: space-between;
}
.nav-btn {
  min-width: 64px;
  min-height: 64px;
  font-size: 1.25rem;
}
.tables {
  display: flex;
  flex-wrap: wrap;
  list-style: none;
  padding: 0;
  gap: 0.5rem;
}
.table-btn {
  min-width: 64px;
  min-height: 64px;
  font-size: 1.25rem;
  touch-action: manipulation;
}
</style>

