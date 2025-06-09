export interface User {
  id: number;
  email: string;
  userIdentifier: string;
  roles: Array<string>;
  fullName: string;
  [key: string]: unknown;
}

export interface Response<T> {
  success: boolean;
  status: number;
  message?: string | null;
  data: T;
}

interface AuthRequest {
  username: string;
  password: string;
}

export type FormFieldOptions = {
  name: string;
  type: string;
  placeholder: string | undefined;
  label: string;
  rules: Record<string, any> | undefined;
}