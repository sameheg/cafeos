import { mount } from '@vue/test-utils';
import { i18n } from '../i18n';

const modules = [
  'Billing',
  'Core',
  'Crm',
  'EquipmentMaintenance',
  'FloorPlanDesigner',
  'HrJobs',
  'Inventory',
  'Jobs',
  'Kds',
  'Loyalty',
  'Marketplace',
  'Membership',
  'Notifications',
  'Pos',
  'Procurement',
  'QrOrdering',
  'Rentals',
  'Reports',
  'SuperAdmin',
];

describe('Module Dashboard components', () => {
  modules.forEach((name) => {
    it(`${name} dashboard renders with i18n and RTL classes`, async () => {
      const component = (await import(`../Modules/${name}/Dashboard.vue`)).default;
      const wrapper = mount(component, { global: { plugins: [i18n] } });
      const key = `modules.${name.toLowerCase()}.dashboard`;
      expect(wrapper.text()).toBe(i18n.global.t(key));
      expect(wrapper.classes()).toContain('rtl:text-right');
      expect(wrapper.classes()).toContain('ltr:text-left');
    });
  });
});
