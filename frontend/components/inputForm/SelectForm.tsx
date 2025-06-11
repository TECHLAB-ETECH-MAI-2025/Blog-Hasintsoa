import { cn } from "@/libs/util";

function SelectForm({ className }: { className: string | undefined }) {
  return (
    <fieldset className="fieldset mb-3">
      <legend className="fieldset-legend">Page title</legend>
      <select
        defaultValue="Pick a color"
        className={cn("select validator", className)}
      >
        <option disabled={true}>Pick a color</option>
        <option>Crimson</option>
        <option>Amber</option>
        <option>Velvet</option>
      </select>
      <p className="label">You can edit page title later on from settings</p>
    </fieldset>
  );
}

export default SelectForm;
