import { createApp } from 'vue';
import Kiosk from './components/Kiosk.vue';

const el = document.getElementById('kiosk-app');

if (el) {
    const translations = JSON.parse(el.dataset.translations);
    createApp(Kiosk, { translations }).mount(el);
}
