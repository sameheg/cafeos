const readline = require('readline');

const rl = readline.createInterface({ input: process.stdin });

rl.on('line', (line) => {
  try {
    const order = JSON.parse(line);
    console.log(`KDS received order ${order.id} for table ${order.table_id}`);
  } catch (e) {
    console.error('Invalid order payload');
  }
});
