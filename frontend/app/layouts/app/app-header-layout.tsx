import { ThemeSwitcher } from "@/components";
import { LinkList, UserDropdown } from "@/components/navbar";
import { useAuth } from "@/hooks/useAuth";
import { Link } from "react-router";

function AppHeaderLayout() {
  const { account } = useAuth();

  return (
    <div className="navbar bg-base-100 shadow-sm px-10 sticky top-0 z-50">
      <div className="navbar-start">
        <div className="dropdown">
          <a tabIndex={0} role="button" className="btn btn-ghost lg:hidden">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              className="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="2"
                d="M4 6h16M4 12h8m-8 6h16"
              />
            </svg>
          </a>
          <ul
            tabIndex={0}
            className="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow"
          >
            <LinkList />
          </ul>
        </div>
        <Link to={"/"} className="btn btn-ghost text-xl">
          Symfony Blog
        </Link>
      </div>
      <div className="navbar-center hidden lg:flex">
        <ul className="menu menu-horizontal px-1">
          <LinkList />
        </ul>
      </div>
      <div className="navbar-end">
        <ThemeSwitcher />

        {account ? (
          <UserDropdown />
        ) : (
          <div className="flex gap-3">
            <Link to={"/sign-in"} className="btn btn-primary">
              Se connecter
            </Link>
            <Link to={"/register"} className="btn btn-primary">
              S'inscrire
            </Link>
          </div>
        )}
      </div>
    </div>
  );
}

export default AppHeaderLayout;
