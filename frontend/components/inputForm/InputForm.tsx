import { cn } from "@/libs/util";
import type { FormFieldOptions } from "@/types";
import type {
  FieldErrors,
  FieldValues,
  UseFormRegister
} from "react-hook-form";

function InputForm({
  register,
  value = undefined,
  options,
  className,
  errors,
  disabled = false
}: {
  register: UseFormRegister<any>;
  value: string | undefined;
  options: FormFieldOptions;
  className: string;
  errors: FieldErrors<FieldValues>;
  disabled: boolean | undefined;
}) {
  const errorField = errors[options.name];

  return (
    <fieldset className="fieldset mb-3">
      <legend className="fieldset-legend">{options.label}</legend>
      {options.type === "textarea" ? (
        <textarea
          {...register(options.name, options.rules)}
          className={cn("textarea validator", className)}
          defaultValue={value}
          placeholder={options.placeholder}
          aria-invalid={errorField ? true : false}
          disabled={disabled}
        ></textarea>
      ) : (
        <input
          {...register(options.name, options.rules)}
          type={options.type}
          defaultValue={value}
          className={cn("input validator", className)}
          placeholder={options.placeholder}
          aria-invalid={errorField ? true : false}
          disabled={disabled}
        />
      )}
      {errorField && (
        <p className="validator-hint">{errorField.message?.toString()}</p>
      )}
    </fieldset>
  );
}

export default InputForm;
