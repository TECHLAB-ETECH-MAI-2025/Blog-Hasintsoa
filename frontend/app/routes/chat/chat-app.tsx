import { Spinner } from "@/components";
import {
  ChatBubble,
  ChatInput,
  ChatUserCard,
  ChatUserSkeleton
} from "@/components/chat";
import { useAccount } from "@/hooks/useAccount";
import { useApiFetchPaginated } from "@/hooks/useApiFetchPaginated";
import { wait } from "@/libs/util";
import { chatService } from "@/services/ChatService";
import { userService } from "@/services/UserService";
import type { Author, Message } from "@/types";
import { useEffect, useRef, useState } from "react";
import { useForm } from "react-hook-form";
import { FaComments } from "react-icons/fa6";

function ChatApp() {
  const { account } = useAccount();
  const { rows: users, loading: loadingUser } = useApiFetchPaginated<
    Iterable<Author>
  >(userService.getAllPaginated.bind(userService), 20);
  const [userId, setUserId] = useState(0);
  const [messages, setMessages] = useState<Array<Message>>([]);
  const [loading, setLoading] = useState(false);
  const bottomMessage = useRef(null);

  const getMessageFromUser = async (userId: number) => {
    setLoading(true);
    await wait();
    const { data } = await chatService.getMessagesBetweenUser(userId);
    setMessages(data);
    setLoading(false);
  };

  useEffect(() => {
    const url = new URL("http://localhost:3000/.well-known/mercure");
    url.searchParams.set(
      "topic",
      chatService.generateChatMessagesUrl(userId, account.id)
    );
    const eventSource = new EventSource(url.toString());
    eventSource.onmessage = (event: any) => {
      const { message }: { message: Message } = JSON.parse(event.data);
      setMessages((lastMessages) => [...lastMessages, message]);
    };
  }, [userId]);

  useEffect(() => {
    if (bottomMessage.current) {
      (bottomMessage.current as any).scrollIntoView({ behavior: "smooth" });
    }
  }, [messages]);

  const {
    register,
    handleSubmit,
    formState: { errors, isSubmitting },
    setValue
  } = useForm();

  const onSubmit = async ({ content }: any) => {
    await wait();
    await chatService.sendMessage(userId, content);
    setValue("content", "");
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

          <div className="flex-1 overflow-y-auto divide-y divide-gray-200">
            {!loadingUser ? (
              <>
                {users &&
                  Array.from(users).map((user, index) => (
                    <ChatUserCard
                      isActive={userId == user.id}
                      user={user}
                      key={index}
                      onClick={() => {
                        setUserId(user.id);
                        getMessageFromUser(user.id);
                      }}
                    />
                  ))}
              </>
            ) : (
              <>
                {Array.from({ length: 4 }).map((_, index) => (
                  <ChatUserSkeleton key={index} />
                ))}
              </>
            )}
          </div>
        </div>
        <div className="chat-section w-full md:w-2/3 flex flex-col chat-wrapper">
          <div className="flex-1 overflow-y-auto p-4 bg-gray-50 rounded-lg shadow-inner flex flex-col space-y-4 chat-messages-container">
            {loading ? (
              <>
                <div className="h-screen flex items-center justify-center">
                  <Spinner className="w-52" />
                </div>
              </>
            ) : (
              <>
                {messages.length !== 0 ? (
                  <>
                    {messages.map((message, index) => (
                      <ChatBubble
                        key={index}
                        isCurrentUser={account.id === message.sender.id}
                        message={message.content}
                        sender={
                          message.receiver.firstName +
                          " " +
                          message.receiver.lastName
                        }
                      />
                    ))}
                  </>
                ) : (
                  <div className="flex flex-col justify-center items-center h-full">
                    <FaComments size={150} />
                    <h1>Pas de conversation</h1>
                  </div>
                )}
              </>
            )}
            <div ref={bottomMessage}></div>
          </div>
          <ChatInput
            register={register}
            onSubmit={handleSubmit(onSubmit)}
            errors={errors}
            isSubmitting={isSubmitting}
          />
        </div>
      </div>
    </div>
  );
}

export default ChatApp;
