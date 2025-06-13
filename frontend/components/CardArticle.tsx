import { articleService } from "@/services/ArticleService";
import type { Article } from "@/types";
import { useState } from "react";
import { FaRegThumbsUp, FaThumbsUp } from "react-icons/fa6";
import { Link } from "react-router";

function CardArticle({ article }: { article: Article }) {
  const [like, setLike] = useState(false);

  /** évenement sur clique pour le système de like */
  const likeArticle = async () => {
    const { liked } = await articleService.likeArticleByArticleId(article.id);
    setLike(liked);
  };

  return (
    <div className="card w-96 bg-base-100 card-md shadow-lg">
      <div className="card-body">
        <h2 className="card-title">{article.title}</h2>
        <p>
          {article.content.length > 100
            ? article.content.slice(0, 150) + " . . . ."
            : article.content}
        </p>
        <div className="card-actions">
          {Array.from(article.categories).map((category) => (
            <div className="badge badge-md badge-outline">{category.title}</div>
          ))}
        </div>
        <div className="justify-between items-center card-actions">
          <div className="flex items-center text-sm text-gray-500">
            <span>{new Date(article.createdAt).toDateString()}</span>
            <span className="mx-2">•</span>
            <button
              onClick={likeArticle}
              type="button"
              className="flex items-center gap-2 border border-slate-500 px-2 text-sm rounded-4xl cursor-pointer"
            >
              {like ? (
                <FaThumbsUp className="text-blue-600" size={18} />
              ) : (
                <FaRegThumbsUp className="text-black" size={18} />
              )}
            </button>
          </div>
          <Link to={`/articles/${article.id}`} className="btn btn-primary">
            Voir plus
          </Link>
        </div>
      </div>
    </div>
  );
}

export default CardArticle;
