function LinkList() {
  return (
    <>
      <li>
        <a>Item 1</a>
      </li>
      <li>
        <details>
          <summary>Blog</summary>
          <ul className="p-2">
            <li>
              <a>Nouvelle articles</a>
            </li>
            <li>
              <a>Submenu 2</a>
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
