<?php
/**
 * @author Yurguis Garcia <yurguis@gmail.com>
 */

namespace TelegramBot\Service;

use Laminas\Feed\Reader\Reader;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use TelegramBot\Cache\Client as CacheClient;
use TelegramBot\Feed\Client as FeedClient;
use TelegramBot\Feed\Feed;
use TelegramBot\Feed\FeedFactory;
use TelegramBot\Telegram\Client as TelegramClient;
use TelegramBot\Telegram\Message;
use TelegramBot\Telegram\ChatFactory;

class FeedReaderService
{
    protected TelegramClient $telegramClient;
    protected FeedFactory $feedFactory;
    protected ChatFactory $chatFactory;
    protected AdapterInterface $cacheAdapter;

    public function __construct(
        TelegramClient $telegramClient,
        FeedFactory    $feedFactory,
        ChatFactory    $chatFactory,
        CacheClient    $cacheClient
    ) {
        $this->telegramClient = $telegramClient;
        $this->chatFactory    = $chatFactory;
        $this->feedFactory    = $feedFactory;
        $this->cacheAdapter   = $cacheClient->getAdapter();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface|InvalidArgumentException
     */
    public function process(string $name = null): void
    {
        Reader::setHttpClient(new FeedClient());

        $feed = $this->feedFactory->get($name);
        if (!$feed) {
            $feed = $this->feedFactory->all();
        }

        if ($feed instanceof Feed) {
            $feed = [$feed];
        }

        foreach ($feed as $item) {
            $this->handleFeed($item);
        }
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws InvalidArgumentException
     */
    private function handleFeed(Feed $feed): void
    {
        $cacheKey  = md5($feed->getUrl());
        $cacheItem = $this->cacheAdapter->getItem($cacheKey);
        if (!$cacheItem->isHit()) {
            $reader = Reader::import($feed->getUrl());

            $cacheItem->set($reader->saveXml());
            $cacheItem->expiresAfter(60);

            $this->cacheAdapter->save($cacheItem);
        }

        $reader = Reader::importString($cacheItem->get());

        foreach ($reader as $entry) {
            if (false === $feed->getKeyword()->matches($entry->getTitle(), $entry->getDescription())) {
                continue;
            }

            $cacheKey = "entry-{$entry->getId()}";
            $cacheItem = $this->cacheAdapter->getItem($cacheKey);
            if ($cacheItem->isHit()) {
                continue;
            }

            $cacheItem->set($entry->getId());
            $cacheItem->expiresAfter(3600); // 1 hr

            $this->cacheAdapter->save($cacheItem);

            foreach ($feed->getMessage() as $message) {
                $chat = $this->chatFactory->get($message);
                if (!$chat) {
                    continue;
                }

                $telegramMessage = new Message(
                    $chat,
                    $entry->getTitle(),
                    $entry->getDescription()
                );

                $this->telegramClient->sendMessage($telegramMessage);
            }
        }
    }

}