<template>
  <div class="kds-board">
    <div v-for="ticket in tickets" :key="ticket.id" class="ticket">
      <h3>Ticket #{{ ticket.id }}</h3>
      <ul>
        <li v-for="item in ticket.items" :key="item">{{ item }}</li>
      </ul>
      <button @click="complete(ticket)">Complete</button>
    </div>
  </div>
</template>

<script>
import { queueRequest } from './offline'

export default {
  name: 'TicketBoard',
  data() {
    return { tickets: [] }
  },
  created() {
    this.fetchTickets()
    this.connectWs()
  },
  methods: {
    async fetchTickets() {
      try {
        const res = await fetch('/api/kds/tickets')
        const data = await res.json()
        this.tickets = data.tickets || []
      } catch (e) {
        // ignore
      }
    },
    connectWs() {
      try {
        const ws = new WebSocket(`ws://${window.location.host}/ws/kds`)
        ws.onmessage = (e) => {
          const ticket = JSON.parse(e.data)
          const idx = this.tickets.findIndex(t => t.id === ticket.id)
          if (idx >= 0) {
            this.$set(this.tickets, idx, ticket)
          } else {
            this.tickets.push(ticket)
          }
        }
      } catch (e) {
        // ignore
      }
    },
    async complete(ticket) {
      this.tickets = this.tickets.filter(t => t.id !== ticket.id)
      await queueRequest(`/api/kds/tickets/${ticket.id}/status`, 'POST', { status: 'done' })
    }
  }
}
</script>

<style scoped>
.kds-board { display: flex; flex-wrap: wrap; }
.ticket { border: 1px solid #ccc; padding: 1rem; margin: 0.5rem; width: 200px; }
</style>
