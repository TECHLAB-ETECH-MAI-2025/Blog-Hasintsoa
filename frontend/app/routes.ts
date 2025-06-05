import { type RouteConfig, index, layout, route } from "@react-router/dev/routes";

export default [
  layout("layouts/app/app-layout.tsx", [
    index("routes/home.tsx"),
    route("articles", "routes/article/list-article.tsx"),
    route("articles/:id", "routes/article/show-article.tsx"),
    route("articles/new", "routes/article/new-article.tsx"),
    route("categories", "routes/category/list-category.tsx"),
  ])
] satisfies RouteConfig;
