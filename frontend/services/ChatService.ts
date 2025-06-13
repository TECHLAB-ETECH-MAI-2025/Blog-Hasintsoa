import { BACKEND_URL } from "@/configs/env";
import { ApiError } from "@/libs/api";
import type { Message } from "@/types";

export class ChatService {
  #backendUrl: string;

  constructor() {
    this.#backendUrl = BACKEND_URL;
  }

  async getMessagesBetweenUser(userId: number): Promise<{ data: Array<Message> }> {
    const r = await fetch(`${this.#backendUrl}/api/messages/${userId}`, {
      method: "GET",
      credentials: "include",
      headers: {
        "Accept": "application/json"
      }
    });
    if (r.ok) return r.json() as Promise<{ data: Array<Message> }>
    throw new ApiError(r.status, await r.json())
  }

  async sendMessage(userId: number, data: any): Promise<any> {
    const r = await fetch(`${this.#backendUrl}/api/chat/send/${userId}`, {
      method: "POST",
      credentials: "include",
      body: JSON.stringify({ content: data }),
      headers: {
        "Accept": "application/json",
        "Content-Type": "application/json"
      }
    });
    if (r.ok) return r.json() as Promise<any>
    throw new ApiError(r.status, await r.json())
  }

  generateChatMessagesUrl(messageSenderId: number, userId: number): string {
    const id1 = Math.min(messageSenderId, userId);
    const id2 = Math.max(messageSenderId, userId);
    return `https://127.0.0.1:8000/front/chat/messages/${id1}/${id2}`;
  }
}

export const chatService: ChatService = new ChatService();