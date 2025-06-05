function CommentCard() {
  return (
    <>
      <div className="flex space-x-4">
        <div className="flex-1">
          <div className="bg-gray-50 p-4 rounded-lg">
            <div className="flex justify-between items-center mb-2">
              <h4 className="font-bold">Michael Chen</h4>
              <span className="text-sm text-gray-500">2 days ago</span>
            </div>
            <p className="text-gray-700">
              Great article! I've been experimenting with Qwik on a side project
              and it's game-changing for performance. Have you tried their
              Resumability feature with large SPAs?
            </p>
          </div>
        </div>
      </div>
    </>
  );
}

export default CommentCard;
