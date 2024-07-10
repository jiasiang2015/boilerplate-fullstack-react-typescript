
declare interface Window {
    appUrl: string;
    appVersion: string;
    appTimeZone: string;

    liffId: string;
    liffLoginMockEnable: boolean;
    liffUrl: string;

    assetUrl: (filePath: string) => string;
}
