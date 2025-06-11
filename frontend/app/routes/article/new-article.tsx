import {
  InputForm,
  SelectFormMultiple,
  SubmitBtn
} from "@/components/inputForm";
import { yupResolver } from "@hookform/resolvers/yup";
import { useForm } from "react-hook-form";
import { FaPaperPlane } from "react-icons/fa6";
import { ArticleForm as FormFields } from "@/forms/ArticleForm";
import { categoryService } from "@/services/CategoryService";
import { wait } from "@/libs/util";
import { articleService } from "@/services/ArticleService";
import { useNavigate } from "react-router";
import toast from "react-hot-toast";
import type { Response } from "@/types";
import { useEffect } from "react";
import { useAccount } from "@/hooks/useAccount";

function NewArticle() {
  const {
    register,
    handleSubmit,
    formState: { errors, isSubmitting },
    control
  } = useForm({
    resolver: yupResolver(FormFields.schema)
  });
  const navigate = useNavigate();
  const { isGranted } = useAccount();

  useEffect(() => {
    if (!isGranted("ROLE_USER")) navigate("/");
  }, []);

  const onSubmit = async (data: {
    title: string;
    content: string;
    categories: any[];
  }) => {
    await wait();
    data.categories = Array.from(data.categories, (category) => category.value);
    const { success } = await articleService.addNew<Response<unknown>>(data);
    if (success) {
      toast.success("Article publié avec succès !");
      navigate("/articles");
    }
  };

  return (
    <main className="container mx-auto px-4 py-8">
      <div className="max-w-5xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
        <div className="px-8 py-6">
          <h1 className="text-3xl font-bold mb-6">
            Ecrire une nouvelle article
          </h1>
          <form onSubmit={handleSubmit(onSubmit)}>
            <InputForm
              className="w-full"
              errors={errors}
              register={register}
              value=""
              options={FormFields.title}
              disabled={false}
            />

            <SelectFormMultiple
              control={control}
              errors={errors}
              fetchCb={categoryService.getAll.bind(categoryService)}
              options={FormFields.categories}
              values={[]}
            />

            <InputForm
              className="w-full min-h-64"
              errors={errors}
              register={register}
              value=""
              options={FormFields.content}
              disabled={false}
            />

            <div className="flex justify-end gap-4">
              <SubmitBtn
                className="btn btn-primary"
                isSubmitting={isSubmitting}
                disabled={isSubmitting}
                spinnerClass="text-slate-900"
              >
                Publier Article
                <FaPaperPlane />
              </SubmitBtn>
            </div>
          </form>
        </div>
      </div>
    </main>
  );
}

export default NewArticle;
