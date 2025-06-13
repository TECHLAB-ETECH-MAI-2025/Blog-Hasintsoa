import { BaseService } from "./BaseService";

export class UserService extends BaseService {

  constructor() {
    super('/api/users');
  }

}

export const userService = new UserService();