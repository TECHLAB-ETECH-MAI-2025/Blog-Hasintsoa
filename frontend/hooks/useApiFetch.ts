import { wait } from "@/libs/util";
import { useCallback, useEffect, useState, useTransition } from "react"

export function useApiFetch<T>(apiFetch: Function, paramId: number | undefined = undefined) {
  const [item, setItem] = useState<T>();
  const [loading, startTransition] = useTransition();

  const fetchItem = useCallback(() => {
    startTransition(async () => {
      try {
        await wait();
        if (paramId) { const { data } = await apiFetch(paramId); setItem(data); }
        else { const { data } = await apiFetch(); setItem(data); }
      } catch (error) {

      }
    });
  }, [])

  useEffect(() => {
    fetchItem();
  }, []);

  return {
    item,
    loading
  }
}