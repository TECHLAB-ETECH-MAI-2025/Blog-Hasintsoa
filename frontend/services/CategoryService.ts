import { BaseService } from "./BaseService";

export class CategoryService extends BaseService {

  constructor() {
    super('/api/categories');
  }

}

export const categoryService = new CategoryService();