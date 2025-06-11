import { BACKEND_URL } from "@/configs/env";
import { ApiError } from "@/libs/api";

export class BaseService {
  protected _backendUrl: string;
  protected _requestPrefix: string;

  constructor(requestPrefix: string) {
    this._backendUrl = BACKEND_URL;
    this._requestPrefix = requestPrefix;
  }

  async getAll<T>(): Promise<T> {
    const r = await fetch(`${this._backendUrl + this._requestPrefix}`, {
      method: "GET",
      credentials: "include",
      headers: {
        "Accept": "application/json"
      }
    });
    if (r.ok) return r.json() as Promise<T>;
    throw new ApiError(r.status, await r.json())
  }

  async getAllPaginated<T>(page: number, size: number = 10): Promise<T> {
    const url = new URL(`${this._backendUrl + this._requestPrefix}/paginated`)
    url.searchParams.set("page", page.toString())
    url.searchParams.set("size", size.toString())
    const r = await fetch(url.toString(), {
      method: "GET",
      credentials: "include",
      headers: {
        "Accept": "application/json"
      }
    })
    if (r.ok) return r.json();
    throw new ApiError(r.status, await r.json())
  }

  async getById<T>(id: number): Promise<T> {
    const r = await fetch(`${this._backendUrl + this._requestPrefix}/${id}`, {
      method: "GET",
      credentials: "include",
      headers: {
        "Accept": "application/json"
      }
    })
    if (r.ok) return r.json() as Promise<T>
    throw new ApiError(r.status, await r.json());
  }

  async addNew<T>(data: Record<string, unknown>): Promise<T> {
    const r = await fetch(`${this._backendUrl + this._requestPrefix}`, {
      method: "POST",
      credentials: "include",
      body: JSON.stringify(data),
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json"
      }
    })
    if (r.ok) return r.json() as Promise<T>
    throw new ApiError(r.status, await r.json())
  }

}