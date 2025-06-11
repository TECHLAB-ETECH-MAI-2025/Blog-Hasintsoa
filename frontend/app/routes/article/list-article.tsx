import { CardArticle } from "@/components";

function ListArticle() {
  return (
    <div className="container mx-auto px-12 py-6">
      <h1 className="text-3xl font-bold mb-6">Articles du Blog</h1>
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <CardArticle />
        <CardArticle />
        <CardArticle />
        <CardArticle />
        <CardArticle />
        <CardArticle />
      </div>
      <div className="flex items-center justify-center mt-8">
        <div className="join">
          <button className="join-item btn">Previous page</button>
          <button className="join-item btn">1</button>
          <button className="join-item btn btn-active">2</button>
          <button className="join-item btn btn-disabled">...</button>
          <button className="join-item btn">3</button>
          <button className="join-item btn">4</button>
          <button className="join-item btn">Next</button>
        </div>
      </div>
    </div>
  );
}

export default ListArticle;
