import { UseTranslationOptions, useTranslation } from "react-i18next";
import { KeyPrefix, _Resources } from "i18next";

export function useManageTranslation<T>(prefix: UseTranslationOptions<KeyPrefix<"manage">>['keyPrefix']) {
    return useTranslation('manage', { keyPrefix: prefix });
}

export function useErrorTranslation() {
    return useTranslation('error');
}

