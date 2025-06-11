function NextPageBtn({
  onClick,
  disabled = false
}: {
  onClick: () => void;
  disabled: boolean;
}) {
  return (
    <>
      <button className="join-item btn" onClick={onClick} disabled={disabled}>
        Next
      </button>
    </>
  );
}

export default NextPageBtn;
