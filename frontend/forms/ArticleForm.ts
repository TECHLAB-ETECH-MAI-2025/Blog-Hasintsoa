import type { FormFieldOptions, SelectFieldOptions } from "@/types"
import * as yup from "yup";

export const ArticleForm: {
  title: FormFieldOptions;
  content: FormFieldOptions;
  categories: SelectFieldOptions;
  schema: yup.ObjectSchema<{
    title: string;
    content: string;
    categories: string[];
  }, yup.AnyObject, {}, "">
} = {
  title: {
    label: "Titre",
    name: "title",
    type: "text",
    placeholder: "Entrez un titre pour votre article",
    rules: undefined,
  },
  content: {
    label: "Contenu",
    name: "content",
    type: "textarea",
    placeholder: "Écrivez le contenu de votre article ici...",
    rules: undefined,
  },
  categories: {
    label: "Catégories",
    name: "categories",
    type: "select",
    placeholder: undefined,
    rules: undefined,
    selectOptions: {
      id: "id",
      value: "title"
    }
  },
  schema: yup.object({
    title: yup.string().required().min(2),
    content: yup.string().required(),
    categories: yup.array().required().min(2)
  })
}