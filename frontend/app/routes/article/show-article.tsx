import { CommentCard } from "@/components";
import { FaPaperPlane } from "react-icons/fa6";
import { useParams } from "react-router";

function ShowArticle() {
  const { id } = useParams();
  return (
    <>
      <div>
        {/* Hero Section */}
        <section className="bg-gradient-to-r from-primary to-secondary text-white">
          <div className="container mx-auto px-4 py-16 md:py-24">
            <div className="max-w-3xl mx-auto text-center">
              <h1 className="text-4xl md:text-5xl font-bold mb-6">
                The Future of Web Development in 2024
              </h1>
              <div className="flex items-center justify-center space-x-4">
                <div className="avatar">
                  <div className="w-10 rounded-full">
                    <img src="/assets/images/profile_image.jpg" alt="Author" />
                  </div>
                </div>
                <div className="text-left">
                  <p className="font-medium">Sarah Johnson</p>
                  <p className="text-sm opacity-80">
                    Published on May 15, 2024
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
                <h2 className="text-3xl font-bold text-gray-800 mb-6">
                  Introduction to Modern Web Development
                </h2>
                <p className="text-lg text-gray-700 leading-relaxed">
                  The landscape of web development continues to evolve at a
                  rapid pace. As we enter 2024, several key trends are shaping
                  how we build for the web, from the rise of advanced JavaScript
                  frameworks to the increasing importance of performance and
                  accessibility.
                </p>
              </article>
              {/* Tags */}
              <div className="mt-12 pt-6 border-t border-gray-200">
                <div className="flex flex-wrap gap-2">
                  <span className="badge badge-primary">Web Development</span>
                  <span className="badge badge-secondary">JavaScript</span>
                  <span className="badge badge-outline">Trends 2024</span>
                  <span className="badge badge-outline">Frontend</span>
                  <span className="badge badge-outline">Performance</span>
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
                    <h4 className="text-lg font-bold">Sarah Johnson</h4>
                    <p className="text-gray-600">
                      Senior Frontend Developer at TechCorp
                    </p>
                    <p className="mt-2 text-gray-700">
                      Sarah has over 8 years of experience in web development
                      and specializes in JavaScript framework optimization.
                      She's passionate about teaching and writing about modern
                      web technologies.
                    </p>
                    <div className="flex space-x-4 mt-3">
                      <a href="#" className="text-gray-500 hover:text-primary">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          className="h-5 w-5"
                          fill="currentColor"
                          viewBox="0 0 24 24"
                        >
                          <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.553 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                        </svg>
                      </a>
                      <a href="#" className="text-gray-500 hover:text-blue-500">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          className="h-5 w-5"
                          fill="currentColor"
                          viewBox="0 0 24 24"
                        >
                          <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                        </svg>
                      </a>
                      <a href="#" className="text-gray-500 hover:text-blue-700">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          className="h-5 w-5"
                          fill="currentColor"
                          viewBox="0 0 24 24"
                        >
                          <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                        </svg>
                      </a>
                    </div>
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
      </div>
    </>
  );
}

export default ShowArticle;
