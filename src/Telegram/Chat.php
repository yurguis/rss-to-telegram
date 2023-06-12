<?php
/**
 * @author Yurguis Garcia <yurguis@gmail.com>
 */

namespace TelegramBot\Telegram;

class Chat
{
    protected string $chatId;
    protected ?string $topicId;

    public function __construct(array $chat = [])
    {
        $this->chatId  = $chat['chat_id'] ?? null;
        $this->topicId = $chat['topic_id'] ?? null;
    }

    public function getChatId(): ?string
    {
        return $this->chatId;
    }

    public function getTopicId(): ?string
    {
        return $this->topicId;
    }

}