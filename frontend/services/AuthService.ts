import type { AuthRequest, Response, User } from "@/types";
import { BaseService } from "./BaseService";
import { ApiError } from "@/libs/api";

export class AuthService extends BaseService {

  constructor() {
    super("/api/auth");
  }

  login(data: AuthRequest) {
    return fetch(`${this._backendUrl}/api/login`, {
      method: "POST",
      credentials: "include",
      body: JSON.stringify(data),
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json"
      }
    })
  }

  logout() {
    return fetch(`${this._backendUrl}/api/logout`, {
      method: "DELETE",
      credentials: "include"
    })
  }

  async getConnectedUser(): Promise<User> {
    const response = await fetch(`${this._backendUrl}/api/me`, {
      method: "POST",
      credentials: "include",
      headers: {
        Accept: "application/json"
      }
    })
    if (response.ok) {
      const { success, data }: Response<User> = await response.json()
      if (success) return data;
    }
    throw new ApiError(response.status, await response.json());
  }

}

export const authService = new AuthService();