const readline = require('readline');

const rl = readline.createInterface({ input: process.stdin });

rl.on('line', (line) => {
  try {
    const data = JSON.parse(line);
    if (data.event === 'kds.ticket.update') {
      console.log(`KDS broadcasted update for ticket ${data.ticket.id}`);
    } else if (data.event === 'kds.ticket.created') {
      console.log(`KDS received order ${data.ticket.id} for table ${data.ticket.table_id}`);
    } else if (data.id && data.table_id) {
      // backward compatibility for plain ticket payloads
      console.log(`KDS received order ${data.id} for table ${data.table_id}`);
    } else {
      console.error('Unknown payload');
    }
  } catch (e) {
    console.error('Invalid order payload');
  }
});
