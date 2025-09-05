<template>
  <div class="quick-order">
    <input class="form-control mb-2 search" v-model="query" :placeholder="placeholder" />
    <div class="products">
      <button
        v-for="item in filtered"
        :key="item.id"
        class="product-btn"
        @click="$emit('add', item)"
      >
        {{ item.name }}
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'QuickOrderEntry',
  props: {
    items: { type: Array, default: () => [] },
    placeholder: { type: String, default: 'Search…' }
  },
  data () {
    return { query: '' }
  },
  computed: {
    filtered () {
      const q = this.query.toLowerCase()
      return this.items.filter(i => i.name.toLowerCase().includes(q))
    }
  }
}
</script>

<style scoped>
.product-btn {
  min-width: 64px;
  min-height: 64px;
  font-size: 1.25rem;
  margin: 0.25rem;
}
.products {
  display: flex;
  flex-wrap: wrap;
}
.search {
  min-height: 48px;
  font-size: 1.1rem;
}
</style>

