function ChatBubble({
  message,
  sender,
  isCurrentUser
}: {
  message: any;
  sender: any;
  isCurrentUser: boolean;
}) {
  const bubbleClass = isCurrentUser ? "chat chat-end" : "chat chat-start";

  const contentClass = isCurrentUser
    ? "chat-bubble chat-bubble-primary text-white"
    : "chat-bubble chat-bubble-secondary text-white";

  return (
    <div className={bubbleClass}>
      <div className="chat-image avatar">
        <div className="w-10 rounded-full">
          <img src={"/assets/images/profile_image.jpg"} alt="Avatar" />
        </div>
      </div>
      <div className="chat-header">
        {sender === "person1" ? "Vous" : "Autre personne"}
      </div>
      <div className={contentClass}>{message}</div>
    </div>
  );
}

export default ChatBubble;
