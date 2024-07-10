export namespace AssetUtils {

  export function withVerisonUrl(filePath: string) {
    return window.assetUrl(filePath);
  }

  export function withImportUrl(filePath: string) {
    return filePath;
  }
}
