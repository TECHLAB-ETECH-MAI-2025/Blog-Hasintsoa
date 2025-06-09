import type { FormFieldOptions } from "@/types";
import * as yup from "yup";

export const SignInForm: {
  username: FormFieldOptions,
  password: FormFieldOptions,
  schema: yup.ObjectSchema<{
    username: string;
    password: string;
  }, yup.AnyObject, {
    username: undefined;
    password: undefined;
  }, "">
} = {
  username: {
    name: "username",
    type: "email",
    label: "Adresse mail",
    placeholder: "",
    rules: undefined
  },
  password: {
    name: "password",
    type: "password",
    label: "Mot de passe",
    placeholder: "",
    rules: undefined
  },
  schema: yup.object({
    username: yup.string().email().required(),
    password: yup.string().min(6).max(255).required()
  })
}