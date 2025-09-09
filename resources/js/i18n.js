import { watchEffect } from 'vue';
import { createI18n } from 'vue-i18n';
import en from '../../lang/en.json';
import ar from '../../lang/ar.json';

export const i18n = createI18n({
  legacy: false,
  locale: document.documentElement.lang || 'en',
  fallbackLocale: 'en',
  messages: { en, ar },
  flatJson: true,
});

export const setDocumentDirection = () => {
  document.documentElement.dir = i18n.global.locale.value === 'ar' ? 'rtl' : 'ltr';
};

watchEffect(setDocumentDirection);
