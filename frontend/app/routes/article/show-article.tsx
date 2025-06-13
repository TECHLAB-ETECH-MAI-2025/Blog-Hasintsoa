import { CommentCard, Spinner } from "@/components";
import { SubmitBtn } from "@/components/inputForm";
import { RatingBtn } from "@/components/rating";
import { CommentForm as FormField } from "@/forms/ArticleForm";
import { useApiFetch } from "@/hooks/useApiFetch";
import { cn, wait } from "@/libs/util";
import { articleService } from "@/services/ArticleService";
import type { Article, Category, Comment } from "@/types";
import { useEffect, useState, useTransition } from "react";
import { useForm } from "react-hook-form";
import toast from "react-hot-toast";
import { FaPaperPlane, FaRegThumbsUp, FaThumbsUp } from "react-icons/fa6";
import { useParams } from "react-router";

function ShowArticle() {
  const { id } = useParams();
  const [like, setLike] = useState(true);
  const [rate, setRate] = useState(0);
  const [likesCount, setLikesCount] = useState(0);
  const [comments, setComments] = useState<Array<Comment>>([]);
  const [commentsCount, setCommentsCount] = useState(0);
  const [commentLoading, startTransition] = useTransition();

  const {
    register,
    handleSubmit,
    formState: { errors, isSubmitting },
    setValue
  } = useForm();

  /**
   * charger la page avec de vrai donnée
   */
  const initiatePage = async () => {
    const { rates } = await articleService.getRateArticleByArticleId(
      id ? parseInt(id) : 0
    );
    setRate(rates);
    const { liked, likesCount } =
      await articleService.getlikeArticleByArticleId(id ? parseInt(id) : 0);
    setLike(liked);
    setLikesCount(likesCount);
  };

  useEffect(() => {
    initiatePage();
  }, []);

  /** Commenter l'article */
  const onSubmit = async (data: any) => {
    await wait();
    const { comment, commentsCount } = await articleService.addComment(
      data,
      id ? parseInt(id) : 0
    );
    setComments([comment, ...comments]);
    setCommentsCount(commentsCount);
    setValue(FormField.content.name, "");
    toast.success("Commenter avec succès");
  };

  /** charger la page avec l'article */
  const { item, loading } = useApiFetch<Article>(
    articleService.getById.bind(articleService),
    id ? parseInt(id) : undefined
  );

  /** évenement sur clique le système de notation */
  const rateArticle = async (rating: number) => {
    const { rates } = await articleService.rateArticleByArticleId(
      rating,
      id ? parseInt(id) : 0
    );
    setRate(rates);
  };

  /** évenement sur clique pour le système de like */
  const likeArticle = async () => {
    const { liked, likesCount: likeCount } =
      await articleService.likeArticleByArticleId(id ? parseInt(id) : 0);
    setLikesCount(likeCount);
    setLike(liked);
  };

  /** évenement sur clique pour obtenir les commentaires */
  const getCommentByArticleId = () => {
    startTransition(async () => {
      await wait();
      const { comments, commentsCount } = await articleService.getComments(
        id ? parseInt(id) : 0
      );
      setComments(comments);
      setCommentsCount(commentsCount);
    });
  };

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
                  <div className="flex gap-5 items-center mt-4">
                    <div className="border-3 border-warning rounded px-3 py-2">
                      <div className="flex gap-x-1" id="article-range-26">
                        <RatingBtn
                          isSolid={rate >= 1}
                          rating={1}
                          ratingCb={rateArticle}
                        />
                        <RatingBtn
                          isSolid={rate >= 2}
                          rating={2}
                          ratingCb={rateArticle}
                        />
                        <RatingBtn
                          isSolid={rate >= 3}
                          rating={3}
                          ratingCb={rateArticle}
                        />
                        <RatingBtn
                          isSolid={rate >= 4}
                          rating={4}
                          ratingCb={rateArticle}
                        />
                        <RatingBtn
                          isSolid={rate >= 5}
                          rating={5}
                          ratingCb={rateArticle}
                        />
                      </div>
                    </div>
                    <button
                      onClick={likeArticle}
                      type="button"
                      className="btn bg-slate-700/35 hover:border-blue-600 border-2"
                    >
                      {like ? (
                        <FaThumbsUp className="text-blue-600" size={25} />
                      ) : (
                        <FaRegThumbsUp className="text-black" size={25} />
                      )}
                      <span className="bg-white p-1 rounded text-dark ms-3">
                        {likesCount}
                      </span>
                    </button>
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
                  <form onSubmit={handleSubmit(onSubmit)}>
                    <textarea
                      {...register(
                        FormField.content.name,
                        FormField.content.rules
                      )}
                      className={cn(
                        "textarea textarea-bordered w-full h-32",
                        errors[FormField.content.name] &&
                          "border-2 border-red-600"
                      )}
                      placeholder={FormField.content.placeholder}
                    />
                    {errors[FormField.content.name] && (
                      <span className="text-red-600">
                        {errors[FormField.content.name]?.message?.toString()}
                      </span>
                    )}
                    <div className="flex justify-between mt-4">
                      <button type="reset" className="btn btn-outline">
                        Cancel
                      </button>
                      <SubmitBtn
                        isSubmitting={isSubmitting}
                        className="btn btn-primary"
                        disabled={isSubmitting}
                        spinnerClass="text-slate-900"
                      >
                        Post Comment
                        <FaPaperPlane />
                      </SubmitBtn>
                    </div>
                  </form>

                  <div className="mt-8">
                    <h3 className="text-xl font-bold mb-6">
                      Discussion ({commentsCount})
                    </h3>

                    <div className="space-y-6">
                      {comments && comments.length > 0 ? (
                        Array.from(comments, (comment, index) => (
                          <CommentCard comment={comment} key={index} />
                        ))
                      ) : (
                        <div className="flex flex-col gap-y-2 items-center justify-center">
                          <h1>Pas de commentaire</h1>
                          <button
                            onClick={getCommentByArticleId}
                            type="button"
                            className="btn btn-primary"
                          >
                            {commentLoading ? (
                              <span
                                className={"loading loading-bars loading-lg"}
                              ></span>
                            ) : (
                              "Voir les commentaires"
                            )}
                          </button>
                        </div>
                      )}
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
