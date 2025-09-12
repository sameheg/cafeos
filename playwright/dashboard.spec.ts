import { test, expect } from '@playwright/test';

test('kpi endpoint e2e', async ({ request }) => {
  const res = await request.get('/api/v1/dashboard/kpis?time_window=1h');
  expect(res.status()).toBeLessThan(500);
});
