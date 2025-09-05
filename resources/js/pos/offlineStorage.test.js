const { saveSale, getQueuedSales, syncQueuedSales } = require('./offlineStorage');
const FDBFactory = require('fake-indexeddb/lib/FDBFactory');

describe('offline storage', () => {
  beforeEach(() => {
    global.indexedDB = new FDBFactory();
    global.window = {};
    global.navigator = { serviceWorker: { ready: Promise.resolve({ sync: { register: jest.fn() } }) } };
  });

  test('queues sale and syncs', async () => {
    await saveSale({ id: 1, total: 100 });
    let sales = await getQueuedSales();
    expect(sales.length).toBe(1);
    global.fetch = jest.fn().mockResolvedValue({ ok: true });
    await syncQueuedSales();
    expect(global.fetch).toHaveBeenCalled();
    sales = await getQueuedSales();
    expect(sales.length).toBe(0);
  });

  test('retains queued waiter orders across reload', async () => {
    await saveSale({ id: 2, table: 5, tip: 10 });
    jest.resetModules();
    const { getQueuedSales: getAfter } = require('./offlineStorage');
    const after = await getAfter();
    expect(after.length).toBe(1);
    expect(after[0].body.table).toBe(5);
    expect(after[0].body.tip).toBe(10);
  });
});
