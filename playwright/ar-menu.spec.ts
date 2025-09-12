import { test, expect } from '@playwright/test';

// simple e2e flow placeholder

test('view ar menu', async ({ page }) => {
  await page.goto('/ar-menu');
  await expect(page).toHaveTitle(/AR/);
});
