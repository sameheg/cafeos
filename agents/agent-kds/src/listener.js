// Example listener that connects to the KDS WebSocket server
// and prints any incoming ticket updates.

const WebSocket = require('ws');

const ws = new WebSocket('ws://localhost:8080');

ws.on('open', () => {
  // Clients could send a subscribe message if the server required it.
  ws.send(JSON.stringify({ type: 'subscribe' }));
});

ws.on('message', (data) => {
  try {
    const msg = JSON.parse(data);
    if (msg.type === 'ticket.created') {
      console.log(`KDS received ticket ${msg.ticket.id}`);
    } else if (msg.type === 'tickets.active') {
      console.log(`Active tickets: ${msg.tickets.length}`);
    }
  } catch (e) {
    console.error('Invalid message from server');
  }
});
