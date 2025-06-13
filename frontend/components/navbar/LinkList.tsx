import { useAuth } from "@/hooks/useAuth";
import { Link } from "react-router";

function LinkList() {
  const { account } = useAuth();

  return (
    <>
      {account && (
        <li>
          <a>Administration</a>
        </li>
      )}
      <li>
        <details>
          <summary>Blog</summary>
          <ul className="p-2 w-auto md:w-40">
            {account && (
              <li>
                <Link to={"/articles/new"}>Nouvelle articles</Link>
              </li>
            )}
            <li>
              <Link to={"/articles"}>Actualités</Link>
            </li>
          </ul>
        </details>
      </li>
      {account && (
        <li>
          <a>Chatting</a>
        </li>
      )}
    </>
  );
}

export default LinkList;
