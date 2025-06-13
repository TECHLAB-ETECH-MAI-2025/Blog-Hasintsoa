import { cn } from "@/libs/util";
import { FaStar } from "react-icons/fa6";
import { FaRegStar } from "react-icons/fa6";

function RatingBtn({
  rating,
  ratingCb,
  isSolid = false
}: {
  rating: number;
  ratingCb: Function;
  isSolid: boolean;
}) {
  return (
    <a
      type="button"
      className={cn(
        "cursor-pointer",
        isSolid ? "text-yellow-400" : "text-black"
      )}
      onClick={() => ratingCb(rating)}
    >
      {isSolid ? <FaStar size={20} /> : <FaRegStar size={20} />}
    </a>
  );
}

export default RatingBtn;
