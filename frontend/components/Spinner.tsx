import { cn } from "@/libs/util";

function Spinner({ className }: { className: string }) {
  return <span className={cn("loading loading-ring", className)}></span>;
}

export default Spinner;
