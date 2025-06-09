import { useAuth } from "@/hooks/useAuth";
import { FaEnvelope, FaPaperPlane } from "react-icons/fa6";
import { Link } from "react-router";
import AuthLayout from "~/layouts/auth/auth-layout";

function ForgotPassword() {
  const { logout } = useAuth();

  const handleRequest = async () => {
    const r = await fetch("https://127.0.0.1:8000/api/test", {
      method: "GET",
      headers: {
        Accept: "application/json"
      }
    });
    if (r.ok) [console.log(await r.json())];
    console.log("######################");
  };

  return (
    <AuthLayout>
      <button type="button" className="btn btn-primary" onClick={handleRequest}>
        Test Me
      </button>
      <h1 className="text-center text-2xl my-3">Mot de passe oublié</h1>
      <p className="text-center text-gray-500">
        Entrez votre adresse email et nous vous enverrons un lien pour
        réinitialiser votre mot de passe.
      </p>
      <form className="space-y-6">
        <div className="form-control">
          <label className="label">
            <span className="label-text text-gray-700">Email Address</span>
          </label>
          <div className="relative">
            <input
              type="email"
              placeholder="you@example.com"
              className="input input-bordered w-full pl-10 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              required
            />
            <FaEnvelope className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
          </div>
        </div>
        <button
          type="submit"
          className="btn btn-primary w-full bg-gradient-to-r from-indigo-500 to-pink-500 border-0 hover:from-indigo-600 hover:to-pink-600"
        >
          Envoyer le lien de réinitialisation <FaPaperPlane className="ml-2" />
        </button>
      </form>
      <Link to={"/sign-in"} className="link link-primary ml-1 text-center mt-2">
        Retourner au formulaire de connexion
      </Link>
    </AuthLayout>
  );
}

export default ForgotPassword;
