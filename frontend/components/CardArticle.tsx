import { FaThumbsUp } from "react-icons/fa6";

function CardArticle() {
  return (
    <div className="card w-96 bg-base-100 card-md shadow-lg">
      <div className="card-body">
        <h2 className="card-title">Xsmall Card</h2>
        <p>
          A card component has a figure, a body part, and inside body there are
          title and actions parts
        </p>
        <div className="card-actions">
          <div className="badge badge-md badge-outline">Fashion</div>
          <div className="badge badge-md badge-outline">Products</div>
        </div>
        <div className="justify-between items-center card-actions">
          <div className="flex items-center text-sm text-gray-500">
            <span>March 10, 2023</span>
            <span className="mx-2">•</span>
            <span className="flex items-center gap-2 border border-slate-500 px-2 text-sm rounded-4xl cursor-pointer">
              6
              <FaThumbsUp size={18} />
            </span>
          </div>
          <button className="btn btn-primary">Voir plus</button>
        </div>
      </div>
    </div>
  );
}

export default CardArticle;
