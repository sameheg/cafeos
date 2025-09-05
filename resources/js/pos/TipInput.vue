<template>
  <div class="tip-input">
    <label class="sr-only" :for="id">Tip</label>
    <input
      :id="id"
      type="number"
      class="form-control tip-field"
      v-model.number="amount"
      min="0"
      step="0.01"
      @input="$emit('update', amount)"
      placeholder="Tip"
    />
    <div class="btn-group mt-2">
      <button
        v-for="p in presets"
        :key="p"
        class="btn btn-default tip-btn"
        @click="apply(p)"
      >
        {{ p }}%
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TipInput',
  props: {
    value: { type: Number, default: 0 },
    total: { type: Number, default: 0 },
    presets: { type: Array, default: () => [10, 15, 20] },
    id: { type: String, default: 'tip' }
  },
  data () {
    return { amount: this.value }
  },
  watch: {
    value (v) { this.amount = v }
  },
  methods: {
    apply (p) {
      this.amount = parseFloat((this.total * p / 100).toFixed(2))
      this.$emit('update', this.amount)
    }
  }
}
</script>

<style scoped>
.tip-field {
  min-height: 64px;
  font-size: 1.25rem;
}
.tip-btn {
  min-width: 64px;
  min-height: 64px;
  font-size: 1.25rem;
}
</style>

