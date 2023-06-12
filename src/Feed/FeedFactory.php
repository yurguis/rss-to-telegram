<?php
/**
 * @author Yurguis Garcia <yurguis@gmail.com>
 */

namespace TelegramBot\Feed;

class FeedFactory
{
    protected array $feeds = [];

    public function __construct(array $config = [])
    {
        foreach ($config['feeds'] as $name => $feed) {
            $this->feeds[$name] = new Feed($feed);
        }
    }

    public function get(?string $name): ?Feed
    {
        if (!$name) {
            return null;
        }

        return $this->feeds[$name] ?? null;
    }

    public function all(): array
    {
        return $this->feeds;
    }
}