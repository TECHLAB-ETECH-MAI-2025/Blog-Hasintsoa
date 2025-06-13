function ChatInput() {
  return (
    <div className="mt-4 p-4 bg-white rounded-lg shadow-md flex items-center space-x-2">
      <input
        type="text"
        placeholder="Tapez votre message..."
        className="input input-bordered input-primary w-full flex-1 text-gray-800 focus:ring-2 focus:ring-primary focus:border-transparent"
      />
      <button className="btn btn-primary text-white hover:bg-primary-focus active:bg-primary-active transition-colors duration-200">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          strokeWidth="1.5"
          stroke="currentColor"
          className="w-6 h-6"
        >
          <path
            strokeLinecap="round"
            strokeLinejoin="round"
            d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"
          />
        </svg>
        <span className="hidden sm:inline">Envoyer</span>
      </button>
    </div>
  );
}

export default ChatInput;
