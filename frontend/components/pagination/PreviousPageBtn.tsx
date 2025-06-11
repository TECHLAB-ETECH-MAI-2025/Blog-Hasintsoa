function PreviousPageBtn({
  onClick,
  disabled = false
}: {
  onClick: () => void;
  disabled: boolean;
}) {
  return (
    <>
      <button className="join-item btn" onClick={onClick} disabled={disabled}>
        Previous
      </button>
    </>
  );
}

export default PreviousPageBtn;
