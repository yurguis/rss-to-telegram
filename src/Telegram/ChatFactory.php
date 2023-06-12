<?php
/**
 * @author Yurguis Garcia <yurguis@gmail.com>
 */

namespace TelegramBot\Telegram;

class ChatFactory
{
    protected array $chats = [];

    public function __construct(array $config = [])
    {
        foreach ($config['telegram'] as $name => $chat) {
            $this->chats[$name] = new Chat($chat);
        }
    }

    public function get(string $name): ?Chat
    {
        return $this->chats[$name] ?? null;
    }

    public function all(): array
    {
        return $this->chats;
    }

}