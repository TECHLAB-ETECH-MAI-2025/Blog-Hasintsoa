import { BaseService } from "./BaseService";

export class ArticleService extends BaseService {

  constructor() {
    super('/api/articles');
  }

}

export const articleService = new ArticleService();