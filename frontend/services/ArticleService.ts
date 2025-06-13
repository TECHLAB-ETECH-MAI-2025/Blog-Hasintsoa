import { ApiError } from "@/libs/api";
import { BaseService } from "./BaseService";
import type { Comment } from "@/types";

export class ArticleService extends BaseService {

  constructor() {
    super('/api/articles');
  }

  /** Requête pour ajout un commentaire */
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

  /** Request Pour obtenir les Commentaires d'une article */
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

  /** Requête pour aimer aimer un article */
  async likeArticleByArticleId(articleId: number): Promise<{ liked: boolean, articleId: number, likesCount: number }> {
    const r = await fetch(`${this._backendUrl + this._requestPrefix}/${articleId}/like`, {
      method: "POST",
      credentials: "include",
      headers: {
        "Accept": "application/json",
        "Content-Type": "application/json"
      }
    });
    if (r.ok) return r.json() as Promise<{ liked: boolean, articleId: number, likesCount: number }>;
    throw new ApiError(r.status, await r.json())
  }

  /** Requête pour obtenir si l'article est déjà aimé et le nombre de j'aimes */
  async getlikeArticleByArticleId(articleId: number): Promise<{ liked: boolean, articleId: number, likesCount: number }> {
    const r = await fetch(`${this._backendUrl + this._requestPrefix}/${articleId}/like`, {
      method: "GET",
      credentials: "include",
      headers: {
        "Accept": "application/json",
        "Content-Type": "application/json"
      }
    });
    if (r.ok) return r.json() as Promise<{ liked: boolean, articleId: number, likesCount: number }>;
    throw new ApiError(r.status, await r.json())
  }

  /** Requête pour noter une article */
  async rateArticleByArticleId(rating: number, articleId: number): Promise<{ articleId: number, rates: number }> {
    const r = await fetch(`${this._backendUrl + this._requestPrefix}/${articleId}/rate`, {
      method: "POST",
      credentials: "include",
      body: JSON.stringify({ rating }),
      headers: {
        "Accept": "application/json",
        "Content-Type": "application/json"
      }
    });
    if (r.ok) return r.json() as Promise<{ articleId: number, rates: number }>;
    throw new ApiError(r.status, await r.json())
  }

  /** Requête pour obtenir le nombre d'étoile par de l'utilisateur pour l'article */
  async getRateArticleByArticleId(articleId: number): Promise<{ articleId: number, rates: number }> {
    const r = await fetch(`${this._backendUrl + this._requestPrefix}/${articleId}/rate`, {
      method: "GET",
      credentials: "include",
      headers: {
        "Accept": "application/json",
        "Content-Type": "application/json"
      }
    });
    if (r.ok) return r.json() as Promise<{ articleId: number, rates: number }>;
    throw new ApiError(r.status, await r.json())
  }

}

export const articleService = new ArticleService();