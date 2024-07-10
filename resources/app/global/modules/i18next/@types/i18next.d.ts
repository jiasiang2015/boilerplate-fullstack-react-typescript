import { defaultLang, resources } from '../i18n';

declare module 'i18next' {
  interface CustomTypeOptions {
    defaultNS: typeof defaultLang.key;
    resources: typeof resources['enUS'];
  }
}