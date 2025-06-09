import type { User } from "@/types";
import { create } from "zustand";
import { combine } from "zustand/middleware";

export const useAccountStore = create(
  combine({
    account: undefined as undefined | null | User
  }, (set) => ({
    setAccount: (account: User | null) => set({ account })
  }))
)