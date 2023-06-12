<?php
/**
 * @author Yurguis Garcia <yurguis@gmail.com>
 */

namespace TelegramBot\Telegram;

class Message
{
    protected Chat $chat;
    protected string $title;
    protected string $description;

    public function __construct(Chat $chat, string $title, string $description)
    {
        $this->chat        = $chat;
        $this->title       = $title;
        $this->description = $description;
    }

    public function getChat(): Chat
    {
        return $this->chat;
    }

    public function getMessage(): string
    {
        // Build the message string
        $message = "{$this->title} \n{$this->description} \n";

        // Remove html tags
        return str_replace(['<p>', '</p>', '<br />'], ['', '', ' '], $message);
    }

}