import { CardArticle } from "@/components";
import type { Route } from "./+types/home";
import {
  FaCamera,
  FaChartLine,
  FaHeart,
  FaLaptopCode,
  FaPaintbrush,
  FaUtensils
} from "react-icons/fa6";
import { Link } from "react-router";
import { useApiFetchPaginated } from "@/hooks/useApiFetchPaginated";
import type { Article } from "@/types";
import { articleService } from "@/services/ArticleService";
import CardSkeleton from "@/components/CardSkeleton";

export function meta({}: Route.MetaArgs) {
  return [
    { title: "New React Router App" },
    { name: "description", content: "Welcome to React Router!" }
  ];
}

export default function Home() {
  const { rows, loading } = useApiFetchPaginated<Iterable<Article>>(
    articleService.getAllPaginated.bind(articleService),
    6
  );

  return (
    <>
      <section className="hero min-h-[400px] bg-base-200 rounded-box mb-12">
        <div className="hero-content text-center">
          <div className="max-w-2xl">
            <h1 className="text-5xl font-bold">Welcome to My Blog</h1>
            <p className="py-6">
              Discover amazing articles, tutorials, and insights about
              technology, design, and more.
            </p>
            <Link to={"/articles"} className="btn btn-primary">
              Start Reading
            </Link>
          </div>
        </div>
      </section>
      <div className="container mx-auto px-4 py-8">
        <section className="mb-12">
          <h2 className="text-3xl font-bold mb-6">Articles Récents</h2>
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
                {Array.from({ length: 6 }).map((_, index) => (
                  <CardSkeleton key={index} className="min-h-48" />
                ))}
              </>
            )}
          </div>
        </section>
        <div className="flex justify-center">
          <Link to={"/articles"} className="btn btn-outline">
            Voir les articles
          </Link>
        </div>
      </div>
    </>
  );
}
