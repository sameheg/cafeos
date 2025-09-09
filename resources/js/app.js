import './bootstrap';
import { createApp, h, watchEffect } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { createPinia } from 'pinia';
import { createI18n } from 'vue-i18n';
import en from '../../lang/en.json';
import ar from '../../lang/ar.json';

const locale = document.documentElement.lang || 'en';
const i18n = createI18n({
  legacy: false,
  locale,
  fallbackLocale: 'en',
  messages: { en, ar },
  flatJson: true,
});

watchEffect(() => {
  document.documentElement.dir = i18n.global.locale.value === 'ar' ? 'rtl' : 'ltr';
});

createInertiaApp({
  resolve: (name) => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
    return pages[`./Pages/${name}.vue`];
  },
  setup({ el, App, props, plugin }) {
    const pinia = createPinia();
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(pinia)
      .use(i18n)
      .mount(el);
  },
  progress: {
    color: '#4B5563',
  },
});
