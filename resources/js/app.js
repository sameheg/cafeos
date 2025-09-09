import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { createPinia } from 'pinia';
import { i18n } from './i18n';

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
