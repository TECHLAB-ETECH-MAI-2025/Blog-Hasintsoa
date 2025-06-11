import { cn } from "@/libs/util";

function CardSkeleton({ className }: { className: string }) {
  return (
    <div className={cn("skeleton", className)}>
      <h1></h1>
    </div>
  );
}

export default CardSkeleton;
