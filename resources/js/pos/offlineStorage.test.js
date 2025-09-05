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
});
