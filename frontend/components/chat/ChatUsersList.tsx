function ChatUsersList() {
  return (
    <div className="flex-1 overflow-y-auto divide-y divide-gray-200">
      <a
        href="#"
        className="flex items-center p-4 sm:p-4 gap-4 user-list-item transition-all duration-200 ease-in-out cursor-pointer hover:bg-base-100"
      >
        <div className="avatar offline">
          <div className="w-12 h-12 rounded-full ring ring-warning ring-offset-base-100 ring-offset-2">
            <img
              src="/assets/images/profile_image.jpg"
              alt="Avatar de Bob Johnson"
            />
          </div>
        </div>
        <div className="flex-1">
          <h2 className="text-lg font-semibold text-gray-900">Bob Johnson</h2>
          <p className="text-sm text-gray-600 truncate">
            Ok, je te tiens au courant.
          </p>
        </div>
      </a>
      <a
        href="#"
        className="flex items-center p-4 sm:p-4 gap-4 user-list-item transition-all duration-200 ease-in-out cursor-pointer hover:bg-base-100"
      >
        <div className="avatar online">
          <div className="w-12 h-12 rounded-full ring ring-success ring-offset-base-100 ring-offset-2">
            <img
              src="/assets/images/profile_image.jpg"
              alt="Avatar de Carol White"
            />
          </div>
        </div>
        <div className="flex-1">
          <h2 className="text-lg font-semibold text-gray-900">Carol White</h2>
          <p className="text-sm text-gray-600 truncate">
            J'ai hâte de voir les résultats.
          </p>
        </div>
      </a>
    </div>
  );
}

export default ChatUsersList;
