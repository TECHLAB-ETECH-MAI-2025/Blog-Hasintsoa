import { FaArrowRight } from "react-icons/fa6";
import { Link } from "react-router";
import AuthLayout from "~/layouts/auth/auth-layout";
import { useForm } from "react-hook-form";
import { SignInForm as FormFields } from "@/forms/AuthForms";
import { yupResolver } from "@hookform/resolvers/yup";
import { wait } from "@/libs/util";
import type { AuthRequest } from "@/types";
import { useAuth } from "@/hooks/useAuth";
import { InputForm, SubmitBtn } from "@/components/inputForm";

function SignIn() {
  const { login } = useAuth();

  const {
    register,
    handleSubmit,
    formState: { errors, isSubmitting }
  } = useForm({
    resolver: yupResolver(FormFields.schema)
  });

  const onSubmit = async (data: AuthRequest) => {
    await wait();
    await login(data);
  };

  return (
    <AuthLayout>
      <h1 className="text-center text-2xl my-3">Connexion</h1>
      <form onSubmit={handleSubmit(onSubmit)} className="space-y-6">
        <InputForm
          register={register}
          options={FormFields.username}
          className="w-full"
          errors={errors}
          value={"admin@domain.com"}
          disabled={false}
        />

        <InputForm
          register={register}
          options={FormFields.password}
          className="w-full"
          errors={errors}
          value={"Admin@123"}
          disabled={false}
        />

        <div className="flex justify-end items-center mt-2">
          <Link to={"/forgot-password"} className="link link-primary text-sm">
            Forgot password?
          </Link>
        </div>

        <SubmitBtn
          className="btn text-white w-full bg-gradient-to-r from-indigo-500 to-pink-500 border-0 hover:from-indigo-600 hover:to-pink-600"
          isSubmitting={isSubmitting}
          disabled={isSubmitting}
        >
          Se connecter <FaArrowRight className="ml-2" />
        </SubmitBtn>
      </form>
      <p className="text-center text-gray-600 mt-6">
        Vous n'avez pas de compte ?
        <Link to={"/register"} className="link link-primary ml-1">
          S'inscrire
        </Link>
      </p>
    </AuthLayout>
  );
}

export default SignIn;
