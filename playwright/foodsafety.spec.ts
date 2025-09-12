import { test, expect } from '@playwright/test';

test('log flow', async ({ request }) => {
  const res = await request.post('/api/v1/foodsafety/logs', {
    data: { temp: 4, item_id: 'p1' }
  });
  expect(res.ok()).toBeTruthy();
});
