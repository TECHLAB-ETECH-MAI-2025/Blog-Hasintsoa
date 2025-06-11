import { cn } from "@/libs/util";
import NextPageBtn from "./NextPageBtn";
import PreviousPageBtn from "./PreviousPageBtn";

function Pagination({
  currentPage,
  totalPages,
  onPageChange
}: {
  currentPage: number;
  totalPages: number;
  onPageChange: Function;
}) {
  const getVisiblesPages = (maxVisiblesPages: number = 10) => {
    if (totalPages <= maxVisiblesPages) {
      return Array.from({ length: totalPages }, (_, index) => ({
        pageNumber: index + 1
      }));
    } else {
      const visiblePages = [];
      let startPage = Math.max(
        3,
        currentPage - Math.floor(maxVisiblesPages / 2)
      );
      let endPage = Math.min(totalPages - 2, startPage + maxVisiblesPages - 5);
      if (endPage - startPage + 1 < maxVisiblesPages - 4) {
        startPage = Math.max(3, endPage - maxVisiblesPages + 5);
      }

      visiblePages.push({ pageNumber: 1 }, { pageNumber: 2 });
      if (startPage > 3) visiblePages.push({ pageNumber: "..." });

      for (let i = startPage; i <= endPage; i++) {
        visiblePages.push({ pageNumber: i });
      }

      if (endPage < totalPages - 2) visiblePages.push({ pageNumber: "..." });
      visiblePages.push(
        { pageNumber: totalPages - 1 },
        { pageNumber: totalPages }
      );
      return visiblePages;
    }
  };

  return (
    <div className="join">
      <PreviousPageBtn
        onClick={() => onPageChange(currentPage - 1)}
        disabled={currentPage === 1}
      />
      {getVisiblesPages().map((pageItem, index) => {
        if (pageItem.pageNumber !== "...") {
          return (
            <button
              key={index}
              className={cn(
                "join-item btn",
                currentPage === pageItem.pageNumber ? " btn-active" : ""
              )}
              disabled={currentPage === pageItem.pageNumber}
              onClick={() => onPageChange(pageItem.pageNumber)}
            >
              {pageItem.pageNumber}
            </button>
          );
        } else {
          return (
            <button key={index} disabled className="join-item btn-disabled">
              ...
            </button>
          );
        }
      })}
      <NextPageBtn
        onClick={() => onPageChange(currentPage + 1)}
        disabled={currentPage === totalPages}
      />
    </div>
  );
}

export default Pagination;
