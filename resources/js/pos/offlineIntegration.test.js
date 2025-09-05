const { saveSale, getQueuedSales, syncQueuedSales } = require('./offlineStorage');
const FDBFactory = require('fake-indexeddb/lib/FDBFactory');

describe('offline integration', () => {
  let registerMock;

  beforeEach(() => {
    global.indexedDB = new FDBFactory();
    global.window = { SyncManager: function SyncManager() {} };
    registerMock = jest.fn();
    global.navigator = {
      serviceWorker: {
        ready: Promise.resolve({
          sync: { register: registerMock }
        })
      }
    };
  });

  test('queues sale when offline and syncs later', async () => {
    await saveSale({ id: 1, total: 100 });
    expect(registerMock).toHaveBeenCalledWith('sync-sales');

    let sales = await getQueuedSales();
    expect(sales.length).toBe(1);

    global.fetch = jest.fn().mockRejectedValue(new Error('offline'));
    await syncQueuedSales();
    sales = await getQueuedSales();
    expect(sales.length).toBe(1);

    global.fetch = jest.fn().mockResolvedValue({ ok: true });
    await syncQueuedSales();
    sales = await getQueuedSales();
    expect(sales.length).toBe(0);
  });
});
