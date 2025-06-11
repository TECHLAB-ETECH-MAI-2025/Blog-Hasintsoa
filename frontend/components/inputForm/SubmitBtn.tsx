import { cn } from "@/libs/util";
import type { ReactNode } from "react";

function SubmitBtn({
  children,
  className,
  spinnerClass,
  isSubmitting,
  disabled = false
}: {
  children: ReactNode;
  className: string | undefined;
  spinnerClass: string | undefined;
  isSubmitting: boolean;
  disabled: boolean | undefined;
}) {
  return (
    <button type="submit" className={cn(className)} disabled={disabled}>
      {isSubmitting ? (
        <span
          className={cn("loading loading-bars loading-lg", spinnerClass)}
        ></span>
      ) : (
        children
      )}
    </button>
  );
}

export default SubmitBtn;
