import { CardArticle } from "@/components";
import type { Route } from "./+types/home";
import {
  FaCamera,
  FaChartLine,
  FaHeart,
  FaLaptopCode,
  FaPaintbrush,
  FaUtensils
} from "react-icons/fa6";

export function meta({}: Route.MetaArgs) {
  return [
    { title: "New React Router App" },
    { name: "description", content: "Welcome to React Router!" }
  ];
}

export default function Home() {
  return (
    <>
      <section className="hero min-h-[400px] bg-base-200 rounded-box mb-12">
        <div className="hero-content text-center">
          <div className="max-w-2xl">
            <h1 className="text-5xl font-bold">Welcome to My Blog</h1>
            <p className="py-6">
              Discover amazing articles, tutorials, and insights about
              technology, design, and more.
            </p>
            <button className="btn btn-primary">Start Reading</button>
          </div>
        </div>
      </section>
      <div className="container mx-auto px-4 py-8">
        <section className="mb-12">
          <h2 className="text-3xl font-bold mb-6">Featured Posts</h2>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <CardArticle />
            <CardArticle />
            <CardArticle />
          </div>
        </section>

        <section className="mb-12">
          <h2 className="text-3xl font-bold mb-6">Popular Categories</h2>
          <div className="flex flex-wrap gap-4">
            <a className="badge badge-lg badge-primary p-4 hover:scale-105 transition-transform">
              <FaLaptopCode className="mr-2" /> Technology
            </a>
            <a className="badge badge-lg badge-secondary p-4 hover:scale-105 transition-transform">
              <FaPaintbrush className="mr-2" /> Design
            </a>
            <a className="badge badge-lg badge-accent p-4 hover:scale-105 transition-transform">
              <FaChartLine className="mr-2" /> Business
            </a>
            <a className="badge badge-lg badge-neutral p-4 hover:scale-105 transition-transform">
              <FaCamera className="mr-2" /> Photography
            </a>
            <a className="badge badge-lg badge-success p-4 hover:scale-105 transition-transform">
              <FaHeart className=" mr-2" /> Lifestyle
            </a>
            <a className="badge badge-lg badge-warning p-4 hover:scale-105 transition-transform">
              <FaUtensils className="mr-2" /> Food
            </a>
          </div>
        </section>

        <section className="mb-12">
          <h2 className="text-3xl font-bold mb-6">Recent Posts</h2>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <CardArticle />
            <CardArticle />
            <CardArticle />
            <CardArticle />
            <CardArticle />
            <CardArticle />
          </div>
        </section>
        <div className="flex justify-center">
          <button className="btn btn-outline">View All Posts</button>
        </div>
      </div>
    </>
  );
}
