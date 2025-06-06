import { FaLock } from "react-icons/fa6";
import { Link } from "react-router";
import AuthLayout from "~/layouts/auth/auth-layout";

function ResetPassword() {
  return (
    <AuthLayout>
      <h1 className="text-center text-2xl my-3">
        Réinitialisation de mot de passe
      </h1>
      <form className="space-y-6">
        <div className="form-control">
          <label className="label">
            <span className="label-text text-gray-700">Mot de passe</span>
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
        </div>
        <div className="form-control">
          <label className="label">
            <span className="label-text text-gray-700">
              Confirmation mot de passe
            </span>
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
        </div>
        <button
          type="submit"
          className="btn btn-primary w-full bg-gradient-to-r from-indigo-500 to-pink-500 border-0 hover:from-indigo-600 hover:to-pink-600"
        >
          Envoyer
        </button>
      </form>
    </AuthLayout>
  );
}

export default ResetPassword;
