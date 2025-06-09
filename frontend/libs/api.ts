export class ApiError extends Error {

  public statusCode: number;
  public data: Record<string, unknown>

  constructor(statusCode: number, data: Record<string, unknown>) {
    super();
    this.statusCode = statusCode;
    this.data = data;
  }
}
