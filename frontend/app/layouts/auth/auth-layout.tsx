import type { ReactNode } from "react";

function AuthLayout({ children }: { children: ReactNode }) {
  return (
    <div className="flex justify-center items-center h-screen">
      <div className="max-w-md w-full">
        {/* Decorative elements */}
        <div className="absolute top-10 left-10 w-16 h-16 rounded-full bg-purple-200 opacity-60 floating" />
        <div
          className="absolute top-1/4 right-20 w-24 h-24 rounded-full bg-pink-200 opacity-60 floating"
          style={{ animationDelay: "1s" }}
        />
        <div
          className="absolute bottom-20 left-1/4 w-20 h-20 rounded-full bg-indigo-200 opacity-60 floating"
          style={{ animationDelay: "2s" }}
        />
        {/* Main card */}
        <div className="card bg-white shadow-2xl backdrop-blur-sm border border-opacity-10 border-white">
          <div className="card-body">
            <h2 className="text-3xl font-bold text-center text-gray-800">
              Symfony Blog
            </h2>
            {children}
          </div>
        </div>
        <div className="mt-6 text-center text-gray-500 text-sm">
          <p>© 2025 Symfony Blog. All rights reserved.</p>
        </div>
      </div>
    </div>
  );
}

export default AuthLayout;
