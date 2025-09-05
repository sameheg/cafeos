// Example listener that connects to the KDS WebSocket server
// and prints any incoming ticket updates.

const WebSocket = require('ws');
const readline = require('readline');

const station = process.argv[2] || null;
const rl = readline.createInterface({ input: process.stdin });

const ws = new WebSocket('ws://localhost:8080');

ws.on('open', () => {
  // Clients could send a subscribe message if the server required it.
  ws.send(JSON.stringify({ type: 'subscribe' }));
});

ws.on('message', (line) => {
  try {
    const msg = JSON.parse(line);
    if (msg.event === 'kds.ticket.update') {
      console.log(`KDS broadcasted update for ticket ${msg.ticket.id}`);
    } else if (msg.event === 'kds.ticket.created') {
      console.log(
        `KDS received order ${msg.ticket.id} for table ${msg.ticket.table_id}`
      );
    } else if (msg.type === 'ticket.created') {
      console.log(`KDS received ticket ${msg.ticket.id}`);
    } else if (msg.type === 'tickets.active') {
      console.log(`Active tickets: ${msg.tickets.length}`);
    } else if (msg.id && msg.table_id) {
      if (!station || msg.station === station) {
        console.log(
          `KDS${station ? `(${station})` : ''} received order ${msg.id} for table ${msg.table_id}`
        );
      }
    } else {
      console.error('Unknown payload');
    }
  } catch (e) {
    console.error('Invalid message from server');
  }
});

rl.on('line', (input) => {
  ws.send(input);
});
