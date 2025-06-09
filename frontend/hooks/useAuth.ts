import { authService } from "@/services/AuthService";
import { useAccountStore } from "@/store/store";
import type { AuthRequest, User } from "@/types";
import { useCallback } from "react";
import { useNavigate } from "react-router";

export function useAuth() {
  const { account, setAccount } = useAccountStore()
  const navigate = useNavigate()

  const authenticate = useCallback(() => {
    authService.getConnectedUser()
      .then(setAccount)
      .catch(() => setAccount(null))
  }, [])

  const login = useCallback(async (data: AuthRequest) => {
    try {
      await authService.login(data)
      const userInfo = await authService.getConnectedUser()
      setAccount(userInfo)
      navigate("/")
    } catch (error) {
      setAccount(null)
      navigate("/")
    }
  }, [])

  const logout = useCallback(() => {
    authService.logout()
      .then(() => setAccount(null))
      .catch(() => {
        setAccount(null)
        navigate("/")
      })
  }, [])

  return {
    account,
    authenticate,
    login,
    logout
  }
}