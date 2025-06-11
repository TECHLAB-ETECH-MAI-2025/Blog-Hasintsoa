import { CardArticle } from "@/components";
import CardSkeleton from "@/components/CardSkeleton";
import { Pagination } from "@/components/pagination";
import { useApiFetchPaginated } from "@/hooks/useApiFetchPaginated";
import { articleService } from "@/services/ArticleService";
import type { Article } from "@/types";

function ListArticle() {
  const { rows, loading, onPageChange, page, totalItems, totalPages } =
    useApiFetchPaginated<Iterable<Article>>(
      articleService.getAllPaginated.bind(articleService),
      9
    );

  return (
    <div className="container mx-auto px-12 py-6">
      <h1 className="text-3xl font-bold mb-6">Articles du Blog</h1>
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {!loading ? (
          <>
            {rows &&
              Array.from(rows).map((row, index) => (
                <CardArticle article={row} key={index} />
              ))}
          </>
        ) : (
          <>
            {Array.from({ length: 9 }).map((_, index) => (
              <CardSkeleton key={index} className="min-h-48" />
            ))}
          </>
        )}
      </div>
      <div className="flex items-center justify-center mt-8">
        {totalPages !== 1 && (
          <Pagination
            currentPage={page}
            totalPages={totalPages}
            onPageChange={onPageChange}
          />
        )}
      </div>
    </div>
  );
}

export default ListArticle;
