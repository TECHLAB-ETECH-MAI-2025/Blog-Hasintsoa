import { wait } from "@/libs/util";
import { useCallback, useEffect, useState, useTransition } from "react";

export function useApiFetchPaginated<T>(
  apiFetch: (page: number, itemsPerPage: number, searchQuery?: string) => Promise<any>,
  itemsPerPage: number = 10,
  searchQuery?: string
) {
  const [rows, setRows] = useState<T>();
  const [page, setPage] = useState<number>(1);
  const [totalPages, setTotalPages] = useState<number>(0);
  const [totalItems, setTotalItems] = useState<number>(0);
  const [loading, startTransition] = useTransition();

  const fetchDataPaginated = useCallback(async () => {
    startTransition(async () => {
      try {
        await wait();
        const { data } = await apiFetch(page, itemsPerPage, searchQuery);
        setRows(data.rows);
        setTotalPages(prev => prev || data.page.totalPages);
        setTotalItems(prev => prev || data.page.totalElements);
      } catch {

      }
    });
  }, [page, itemsPerPage]);

  useEffect(() => {
    fetchDataPaginated();
  }, [page, itemsPerPage]);

  return {
    rows,
    page,
    totalPages,
    totalItems,
    loading,
    onPageChange: setPage,
  };
}