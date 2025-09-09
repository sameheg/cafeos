import { i18n, setDocumentDirection } from '../i18n';
import { mount } from '@vue/test-utils';
import { vi } from 'vitest';

vi.mock('@inertiajs/vue3', () => ({
  usePage: () => ({ props: { isInventoryEnabled: true, stock: 10 } }),
}));

import Dashboard from '../Pages/Pos/Dashboard.vue';

describe('RTL behavior', () => {
  it('sets document direction to RTL for Arabic locale', () => {
    i18n.global.locale.value = 'ar';
    setDocumentDirection();
    expect(document.documentElement.dir).toBe('rtl');
  });

  it('renders Arabic text on dashboard', () => {
    i18n.global.locale.value = 'ar';
    const wrapper = mount(Dashboard, {
      global: { plugins: [i18n] },
    });
    expect(wrapper.text()).toContain('لوحة تحكم نقاط البيع');
  });
});
