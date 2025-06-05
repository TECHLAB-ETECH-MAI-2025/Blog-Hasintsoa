import { BACKEND_URL } from "@/configs/env";

export class BaseService {
  protected _backendUrl: string;
  protected _requestPrefix: string;

  constructor(requestPrefix: string) {
    this._backendUrl = BACKEND_URL;
    this._requestPrefix = requestPrefix;
  }

}