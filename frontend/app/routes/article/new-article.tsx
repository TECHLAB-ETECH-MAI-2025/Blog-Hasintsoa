import { FaPaperPlane } from "react-icons/fa6";

function NewArticle() {
  return (
    <>
      <main className="container mx-auto px-4 py-8">
        <div className="max-w-5xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
          <div className="px-8 py-6">
            <h1 className="text-3xl font-bold mb-6">
              Ecrire une nouvelle article
            </h1>
            <form id="article-form">
              {/* Article Title */}
              <fieldset className="fieldset mb-6">
                <legend className="fieldset-legend">Titre</legend>
                <input
                  type="text"
                  className="input input-bordered w-full"
                  placeholder="Entrez le titre de l'article ..."
                />
              </fieldset>

              {/* Category Selection */}
              <div className="mb-6">
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Category
                </label>
                <div className="flex flex-wrap gap-2">
                  <label className="cursor-pointer">
                    <input
                      type="checkbox"
                      name="category"
                      defaultValue="technology"
                      className="hidden peer"
                    />
                    <span className="badge badge-outline peer-checked:bg-primary peer-checked:text-white peer-checked:badge-primary">
                      Technology
                    </span>
                  </label>
                  <label className="cursor-pointer">
                    <input
                      type="checkbox"
                      name="category"
                      defaultValue="javascript"
                      className="hidden peer"
                    />
                    <span className="badge badge-outline peer-checked:bg-secondary peer-checked:text-white peer-checked:badge-secondary">
                      JavaScript
                    </span>
                  </label>
                  <label className="cursor-pointer">
                    <input
                      type="checkbox"
                      name="category"
                      defaultValue="design"
                      className="hidden peer"
                    />
                    <span className="badge badge-outline peer-checked:bg-accent peer-checked:text-white peer-checked:badge-accent">
                      Design
                    </span>
                  </label>
                  <label className="cursor-pointer">
                    <input
                      type="checkbox"
                      name="category"
                      defaultValue="productivity"
                      className="hidden peer"
                    />
                    <span className="badge badge-outline peer-checked:bg-purple-500 peer-checked:text-white">
                      Productivity
                    </span>
                  </label>
                </div>
              </div>

              {/* Content Editor */}
              <fieldset className="fieldset mb-6">
                <legend className="fieldset-legend">Content</legend>
                <textarea
                  className="textarea textarea-primary w-full min-h-64 p-4"
                  placeholder="Write a content here"
                ></textarea>
              </fieldset>

              {/* Form Actions */}
              <div className="flex justify-end gap-4">
                <button type="submit" className="btn btn-primary">
                  Publier Article
                  <FaPaperPlane />
                </button>
              </div>
            </form>
          </div>
        </div>
      </main>
    </>
  );
}

export default NewArticle;
