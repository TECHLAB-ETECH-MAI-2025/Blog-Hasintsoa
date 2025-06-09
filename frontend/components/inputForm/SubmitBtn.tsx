import { cn } from "@/libs/util";
import type { ReactNode } from "react";

function SubmitBtn({
  children,
  className,
  isSubmitting,
  disabled = false
}: {
  children: ReactNode;
  className: string | undefined;
  isSubmitting: boolean;
  disabled: boolean | undefined;
}) {
  return (
    <button type="submit" className={cn(className)} disabled={disabled}>
      {isSubmitting ? (
        <span className="loading loading-bars loading-lg text-white"></span>
      ) : (
        children
      )}
    </button>
  );
}

export default SubmitBtn;
