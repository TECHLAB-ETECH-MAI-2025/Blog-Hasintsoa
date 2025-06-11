import { cn, wait } from "@/libs/util";
import type { SelectFieldOptions } from "@/types";
import { useCallback, useEffect, useState, useTransition } from "react";
import {
  Controller,
  type Control,
  type FieldErrors,
  type FieldValues
} from "react-hook-form";
import Select from "react-select";
import makeAnimated from "react-select/animated";

function SelectMultipleForm({
  control,
  options,
  errors,
  fetchCb,
  values = []
}: {
  control: Control | Control<any, any, any>;
  options: SelectFieldOptions;
  errors: FieldErrors<FieldValues>;
  fetchCb: Function;
  values: Array<string>;
}) {
  const [items, setItems] = useState([]);
  const [selected, setSelected] = useState<any>([]);
  const [loading, startTransition] = useTransition();
  const animatedComponents = makeAnimated();

  const errorField = errors[options.name];

  const hydrateSelect = useCallback(() => {
    startTransition(async () => {
      await wait();
      const { data } = await fetchCb();
      setItems(
        data.map((item: Record<string, string>) => {
          return {
            value: item[options.selectOptions.id],
            label: item[options.selectOptions.value]
          };
        })
      );
    });
  }, []);

  useEffect(() => {
    hydrateSelect();
  }, []);

  useEffect(() => {
    if (values.length > 0) setSelected(values);
  }, [values]);

  return (
    <fieldset className="fieldset mb-3">
      <legend className="fieldset-legend">{options.label}</legend>
      {loading ? (
        <div className="skeleton border-2 h-10 w-full rounded-xl"></div>
      ) : (
        <Controller
          name={options.name}
          control={control}
          rules={options.rules}
          render={({ field }) => (
            <Select
              {...field}
              onChange={(selectOptions) => {
                field.onChange(selectOptions);
                setSelected(selectOptions);
              }}
              isMulti
              value={selected}
              components={animatedComponents}
              options={items}
              className={cn(
                "focus:border-0",
                errorField ? "border rounded border-[var(--color-error)]" : ""
              )}
            />
          )}
        />
      )}
      {errorField && (
        <p className="text-[var(--color-error)]">
          {errorField.message?.toString()}
        </p>
      )}
    </fieldset>
  );
}

export default SelectMultipleForm;
