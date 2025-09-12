import { test, expect } from '@playwright/test';

test('schedule and checkin flow', async ({ request }) => {
  // Placeholder E2E test for HRJobs module
  const shift = await request.post('/v1/hr/shifts', {
    data: { employee_id: 'demo', time: new Date().toISOString() },
  });
  expect(shift.status()).toBeLessThan(500);
});

