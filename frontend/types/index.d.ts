export interface User {
  id: number;
  email: string;
  userIdentifier: string;
  roles: Array<string>;
  fullName: string;
  [key: string]: unknown;
}

export interface Category {
  id: number;
  title: string;
  description: string | null;
}

export interface Comment {
  id: number;
  content: string;
  createdAt: string;
  authorDto: Author;
}

export interface Author {
  id: number;
  email: string;
  firstName: string | null;
  lastName: string | null;
  createdAt: string;
}

export interface Article {
  id: number;
  title: string;
  content: string;
  createdAt: string;
  categories: Array<Category>;
  author: Author;
}

export interface Message {
  id: number;
  sender: Author;
  receiver: Author;
  content: string;
  createdAt: string;
}

export interface Response<T> {
  success: boolean;
  status: number;
  message: string | null;
  data: T;
}

interface AuthRequest {
  username: string;
  password: string;
}

export interface FormFieldOptions {
  name: string;
  type: string;
  placeholder?: string | undefined;
  label: string;
  rules?: Record<string, any> | undefined;
}

export interface InputFieldOptions extends FormFieldOptions { }

export interface SelectFieldOptions extends FormFieldOptions {
  selectOptions: {
    id: string;
    value: string;
  }
}