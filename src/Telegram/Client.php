<?php
/**
 * @author Yurguis Garcia <yurguis@gmail.com>
 */

namespace TelegramBot\Telegram;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client
{
    private HttpClientInterface $client;
    private string $botToken;

    public function __construct(string $botToken)
    {
        $this->client = HttpClient::create();
        $this->botToken  = $botToken;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function sendMessage(Message $message): void
    {
        $response = $this->client->request(
            "POST",
            "https://api.telegram.org/bot{$this->botToken}/sendMessage",
            [
                'json' => [
                    'chat_id'              => $message->getChat()->getChatId(),
                    'text'                 => $message->getMessage(),
                    'message_thread_id'    => $message->getChat()->getTopicId(),
                    'disable_notification' => true,
                ],
            ]
        );

        echo $response->getContent()."\n\n";
    }

}