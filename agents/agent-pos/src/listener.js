const readline = require('readline');

const rl = readline.createInterface({ input: process.stdin });

rl.on('line', (line) => {
  try {
    const event = JSON.parse(line);
    if (event.event === 'kds.ticket.update') {
      console.log(`POS received update for ticket ${event.ticket.id}`);
    } else {
      console.log('POS received unknown event');
    }
  } catch (e) {
    console.error('Invalid event payload');
  }
});
