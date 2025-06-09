import { useAuth } from "./useAuth";

export function useAccount() {
  const { account } = useAuth();

  if (!account) throw new Error("L'utilisateur n'est pas authentifié");

  const isGranted = (role: string): boolean =>
    account.roles.includes(role);


  const isAdmin = (): boolean =>
    account.roles.includes("ROLE_ADMIN");


  return {
    account,
    isGranted,
    isAdmin
  }
}