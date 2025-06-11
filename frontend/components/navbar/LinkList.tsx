import { useAuth } from "@/hooks/useAuth";
import { Link } from "react-router";

function LinkList() {
  const { account } = useAuth();

  return (
    <>
      <li>
        <a>Item 1</a>
      </li>
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
      <li>
        <a>Item 3</a>
      </li>
    </>
  );
}

export default LinkList;
