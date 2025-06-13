import type { Comment } from "@/types";

function CommentCard({ comment }: { comment: Comment }) {
  return (
    <>
      <div className="flex space-x-4">
        <div className="flex-1">
          <div className="bg-gray-50 p-4 rounded-lg">
            <div className="flex justify-between items-center mb-2">
              <h4 className="font-bold">
                {comment.authorDto.firstName + " " + comment.authorDto.lastName}
              </h4>
              <span className="text-sm text-gray-500">
                Commenter le{" "}
                {new Date(
                  comment?.createdAt ? comment?.createdAt : ""
                ).toDateString()}
              </span>
            </div>
            <p className="text-gray-700">{comment.content}</p>
          </div>
        </div>
      </div>
    </>
  );
}

export default CommentCard;
