import { useAccount } from "@/hooks/useAccount";
import { useAuth } from "@/hooks/useAuth";
import { Link } from "react-router";

function UserDropdown() {
  const { account } = useAccount();
  const { logout } = useAuth();

  const handleLogout = () => {
    logout();
  };

  return (
    <div className="dropdown dropdown-end">
      <div
        tabIndex={0}
        role="button"
        className="btn btn-ghost btn-circle avatar"
      >
        <div className="w-10 rounded-full">
          <img alt="Profile Image" src="/assets/images/profile_image.jpg" />
        </div>
      </div>
      <ul className="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
        <li>
          <span>{account.email}</span>
        </li>
        <li>
          <Link to={"/profile"} className="justify-between">
            Profile
          </Link>
        </li>
        <li>
          <button
            type="button"
            onClick={handleLogout}
            className="hover:bg-red-600/30"
          >
            Logout
          </button>
        </li>
      </ul>
    </div>
  );
}

export default UserDropdown;
