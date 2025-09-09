import { watchEffect } from 'vue';
import { createI18n } from 'vue-i18n';
import en from '../../lang/en.json';
import ar from '../../lang/ar.json';
import posEn from '../../Modules/Pos/lang/en.json';
import posAr from '../../Modules/Pos/lang/ar.json';

const prefixKeys = (obj, prefix) =>
  Object.fromEntries(Object.entries(obj).map(([key, value]) => [`${prefix}${key}`, value]));

export const i18n = createI18n({
  legacy: false,
  locale: document.documentElement.lang || 'en',
  fallbackLocale: 'en',
  messages: {
    en: { ...en, ...prefixKeys(posEn, 'pos::') },
    ar: { ...ar, ...prefixKeys(posAr, 'pos::') },
  },
  flatJson: true,
});

export const setDocumentDirection = () => {
  document.documentElement.dir = i18n.global.locale.value === 'ar' ? 'rtl' : 'ltr';
};

watchEffect(setDocumentDirection);
