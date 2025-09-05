const readline = require('readline');

const station = process.argv[2] || null;
const rl = readline.createInterface({ input: process.stdin });

rl.on('line', (line) => {
  try {
    const order = JSON.parse(line);
    if (!station || order.station === station) {
      console.log(
        `KDS${station ? `(${station})` : ''} received order ${order.id} for table ${order.table_id}`
      );
    }
  } catch (e) {
    console.error('Invalid order payload');
  }
});
