/* eslint-disable camelcase */
/* eslint-disable import/extensions */
import i18next from "i18next";
import { initReactI18next } from "react-i18next";
import { SupportLangsType } from "@/global/types";

export type Language = { key: SupportLangsType; displayName: string };

export const SupportLangs: { [key in SupportLangsType]: Language } = {
  enUS: {
    key: "enUS",
    displayName: "en-US (America)",
  },
  zhTW: {
    key: "zhTW",
    displayName: "zh-TW (Taiwan)",
  },
};

export const defaultLang: Language = SupportLangs.enUS;

export const resources = {
  [SupportLangs.enUS.key]: {
    manage: '',
    error:  '',
  },
  [SupportLangs.zhTW.key]: {
    manage: '',
    error:  '',
  },
} as const;

/**
 * For Dynamic key
 * @SeeAlso
 * https://stackoverflow.com/questions/70914886/react-i18n-t-function-doesnt-accept-string-variables-typescript-no-over/71896191#71896191
 * @param key dynamic key
 * @returns TemplateStringsArray */
export const normalizeKey = (key: string | number) => key as unknown as TemplateStringsArray;

i18next
  .use(initReactI18next)
  .init({
    resources,
    // Namespace
    ns: ["manage", "error"],
    // default namespace
    defaultNS: "manage",
    // default language
    lng: SupportLangs.enUS.key,
    fallbackLng: SupportLangs.enUS.key,
    keySeparator: ".",
    supportedLngs: [SupportLangs.enUS.key, SupportLangs.thTH.key, SupportLangs.zhTW.key],
    interpolation: { escapeValue: false },
  });


export default i18next;
