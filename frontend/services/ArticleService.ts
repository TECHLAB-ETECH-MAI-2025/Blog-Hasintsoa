import { ApiError } from "@/libs/api";
import { BaseService } from "./BaseService";
import type { Comment } from "@/types";

export class ArticleService extends BaseService {

  constructor() {
    super('/api/articles');
  }

  async addComment({ content }: { content: string }, articleId: number): Promise<{ comment: Comment, commentsCount: number }> {
    const r = await fetch(`${this._backendUrl + this._requestPrefix}/${articleId}/comment`, {
      method: "POST",
      credentials: "include",
      body: JSON.stringify({ content }),
      headers: {
        "Accept": "application/json",
        "Content-Type": "application/json"
      }
    });
    if (r.ok) return r.json() as Promise<{ comment: Comment, commentsCount: number }>;
    throw new ApiError(r.status, await r.json())
  }

  async getComments(articleId: number): Promise<{ comments: Comment[], commentsCount: number }> {
    const r = await fetch(`${this._backendUrl + this._requestPrefix}/${articleId}/comment`, {
      method: "GET",
      credentials: "include",
      headers: {
        "Accept": "application/json",
        "Content-Type": "application/json"
      }
    });
    if (r.ok) return r.json() as Promise<{ comments: Comment[], commentsCount: number }>;
    throw new ApiError(r.status, await r.json())
  }

}

export const articleService = new ArticleService();