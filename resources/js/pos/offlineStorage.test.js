import { saveSale, getQueuedSales, syncQueuedSales } from './offlineStorage';
import { FDBFactory } from 'fake-indexeddb';

describe('offline storage', () => {
  beforeEach(() => {
    global.indexedDB = new FDBFactory();
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
