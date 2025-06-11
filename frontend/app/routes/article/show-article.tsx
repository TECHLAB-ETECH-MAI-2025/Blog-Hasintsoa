import { CommentCard, Spinner } from "@/components";
import { useApiFetch } from "@/hooks/useApiFetch";
import { articleService } from "@/services/ArticleService";
import type { Article, Category } from "@/types";
import { FaPaperPlane } from "react-icons/fa6";
import { useParams } from "react-router";

function ShowArticle() {
  const { id } = useParams();
  const { item, loading } = useApiFetch<Article>(
    articleService.getById.bind(articleService),
    id ? parseInt(id) : undefined
  );

  return (
    <>
      {loading ? (
        <div className="h-screen flex items-center justify-center">
          <Spinner className="w-52" />
        </div>
      ) : (
        <>
          <section className="bg-gradient-to-r from-primary to-secondary text-white">
            <div className="container mx-auto px-4 py-16 md:py-24">
              <div className="max-w-3xl mx-auto text-center">
                <h1 className="text-4xl md:text-5xl font-bold mb-6">
                  {item?.title}
                </h1>
                <div className="flex items-center justify-center space-x-4">
                  <div className="avatar">
                    <div className="w-10 rounded-full">
                      <img
                        src="/assets/images/profile_image.jpg"
                        alt="Author"
                      />
                    </div>
                  </div>
                  <div className="text-left">
                    <p className="font-medium">
                      {item?.author.firstName}
                      &nbsp;
                      {item?.author.lastName}
                    </p>
                    <p className="text-sm opacity-80">
                      Published on{" "}
                      {new Date(
                        item?.createdAt ? item?.createdAt : ""
                      ).toDateString()}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </section>
          {/* Main Content */}
          <main className="container mx-auto px-4 py-12 -mt-12">
            <div className="bg-white rounded-xl shadow-lg overflow-hidden max-w-4xl mx-auto">
              <div className="p-8">
                {/* Article Content */}
                <article className="article-content prose max-w-none">
                  <p className="text-lg text-gray-700 leading-relaxed">
                    {item?.content}
                  </p>
                </article>
                {/* Tags */}
                <div className="mt-12 pt-6 border-t border-gray-200">
                  <div className="flex flex-wrap gap-2">
                    {item?.categories &&
                      Array.from(item?.categories, (category: Category) => (
                        <span className="badge badge-primary">
                          {category.title}
                        </span>
                      ))}
                  </div>
                </div>
                {/* Author Bio */}
                <div className="mt-12 p-6 rounded-lg bg-gray-50">
                  <div className="flex items-center space-x-4">
                    <div className="avatar">
                      <div className="w-16 rounded-full">
                        <img
                          src="/assets/images/profile_image.jpg"
                          alt="Author"
                        />
                      </div>
                    </div>
                    <div>
                      <h4 className="text-lg font-bold">
                        {item?.author.firstName}
                        &nbsp;
                        {item?.author.lastName}
                      </h4>
                    </div>
                  </div>
                </div>

                <div className="mt-12">
                  <h4 className="text-lg font-bold mb-4">Leave a comment</h4>
                  <form>
                    <textarea
                      className="textarea textarea-bordered w-full h-32"
                      placeholder="Write your thoughts here..."
                      defaultValue={""}
                    />
                    <div className="flex justify-between mt-4">
                      <button type="reset" className="btn btn-outline">
                        Cancel
                      </button>
                      <button type="submit" className="btn btn-primary">
                        Post Comment
                        <FaPaperPlane />
                      </button>
                    </div>
                  </form>

                  <div className="mt-8">
                    <h3 className="text-xl font-bold mb-6">Discussion (5)</h3>
                    <div className="space-y-6">
                      <CommentCard />
                      <CommentCard />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </main>
        </>
      )}
    </>
  );
}

export default ShowArticle;
