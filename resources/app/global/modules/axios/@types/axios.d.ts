import "axios";

declare module "axios" {
  export interface AxiosRequestConfig {
    excludeCode?: (string | number)[] | 'all';
    withoutAuth?: boolean;
  }
}
