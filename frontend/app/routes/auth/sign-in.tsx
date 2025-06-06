import { FaArrowRight, FaEnvelope, FaLock } from "react-icons/fa6";
import { Link } from "react-router";
import AuthLayout from "~/layouts/auth/auth-layout";

function SignIn() {
  return (
    <AuthLayout>
      <h1 className="text-center text-2xl my-3">Connexion</h1>
      <form className="space-y-6">
        <div className="form-control">
          <label className="label">
            <span className="label-text text-gray-700">Email Address</span>
          </label>
          <div className="relative">
            <input
              type="email"
              placeholder="you@example.com"
              className="input input-bordered w-full pl-10"
              required
            />
            <FaEnvelope className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
          </div>
        </div>
        <div className="form-control">
          <label className="label">
            <span className="label-text text-gray-700">Password</span>
          </label>
          <div className="relative">
            <input
              type="password"
              placeholder="••••••••"
              className="input input-bordered w-full pl-10 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              required
            />
            <FaLock className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
          </div>
          <div className="flex justify-between items-center mt-2">
            <label className="label cursor-pointer">
              <input
                type="checkbox"
                className="checkbox checkbox-sm checkbox-primary"
              />
              <span className="label-text ml-2 text-gray-600">Remember me</span>
            </label>
            <Link to={"/forgot-password"} className="link link-primary text-sm">
              Forgot password?
            </Link>
          </div>
        </div>
        <button
          type="submit"
          className="btn btn-primary w-full bg-gradient-to-r from-indigo-500 to-pink-500 border-0 hover:from-indigo-600 hover:to-pink-600"
        >
          Se connecter <FaArrowRight className="ml-2" />
        </button>
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
