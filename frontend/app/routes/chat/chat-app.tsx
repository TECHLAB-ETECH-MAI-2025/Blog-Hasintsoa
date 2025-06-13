import { ChatBubble, ChatInput, ChatUsersList } from "@/components/chat";
import { useState } from "react";
import { useForm } from "react-hook-form";

function ChatApp() {
  const [userId, setUserId] = useState(0);
  const {
    register,
    handleSubmit,
    formState: { errors, isSubmitting }
  } = useForm();

  const onSubmit = async (data: any) => {
    console.log(data);
  };

  return (
    <div className="bg-gray-100 flex justify-center items-center min-h-[80vh] p-4">
      <div className="flex flex-col md:flex-row w-full max-w-7xl mx-auto bg-white rounded-lg shadow-xl overflow-hidden h-[80vh]">
        <div className="user-list-section w-full md:w-1/3 border-r border-gray-200 flex flex-col user-list-wrapper">
          <div className="p-4 sm:p-6 border-b border-gray-200 bg-base-200">
            <h1 className="text-2xl sm:text-2xl font-bold text-gray-800">
              Utilisateurs
            </h1>
            <p className="text-gray-600 mt-1 text-sm">
              Choisissez une conversation
            </p>
          </div>
          <ChatUsersList />
        </div>
        <div className="chat-section w-full md:w-2/3 flex flex-col chat-wrapper">
          <div className="flex-1 overflow-y-auto p-4 bg-gray-50 rounded-lg shadow-inner flex flex-col space-y-4 chat-messages-container">
            <ChatBubble
              isCurrentUser={true}
              message={"message"}
              sender={"rakoto"}
            />
          </div>
          <ChatInput />
        </div>
      </div>
    </div>
  );
}

export default ChatApp;
