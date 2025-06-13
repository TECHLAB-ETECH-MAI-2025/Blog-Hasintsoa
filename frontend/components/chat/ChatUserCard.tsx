import { cn } from "@/libs/util";
import type { Author } from "@/types";

function ChatUserCard({
  user,
  isActive,
  onClick
}: {
  user: Author;
  isActive: boolean;
  onClick: () => void;
}) {
  return (
    <a
      type="button"
      className={cn(
        "rounded-2xl my-1 mx-3 flex items-center p-4 sm:p-4 gap-4 user-list-item transition-all duration-200 ease-in-out cursor-pointer hover:bg-blue-300",
        isActive ? "bg-slate-400" : ""
      )}
      onClick={onClick}
    >
      <div className="avatar offline">
        <div className="w-12 h-12 rounded-full ring ring-warning ring-offset-base-100 ring-offset-2">
          <img
            src="/assets/images/profile_image.jpg"
            alt="Avatar de Bob Johnson"
          />
        </div>
      </div>
      <div className="flex-1">
        <h2 className="text-lg font-semibold text-gray-900">{user.email}</h2>
      </div>
    </a>
  );
}

export default ChatUserCard;
