import Vue from 'vue'
import TicketBoard from './TicketBoard.vue'
import { syncQueued } from './offline'

new Vue({
  el: '#kds-app',
  components: { TicketBoard },
  created() {
    if (navigator.onLine) {
      syncQueued()
    }
    window.addEventListener('online', syncQueued)
  }
})
