import { type RouteConfig, index, layout, route } from "@react-router/dev/routes";

export default [
  route("sign-in", "routes/auth/sign-in.tsx"),
  route("register", "routes/auth/register.tsx"),
  route("forgot-password", "routes/auth/forgot-password.tsx"),
  route("reset-password", "routes/auth/reset-password.tsx"),
  layout("layouts/app/app-layout.tsx", [
    index("routes/home.tsx"),
    route("articles", "routes/article/list-article.tsx"),
    route("articles/:id", "routes/article/show-article.tsx"),
    route("articles/new", "routes/article/new-article.tsx"),
    route("categories", "routes/category/list-category.tsx"),
  ])
] satisfies RouteConfig;
