<?php
/**
 * @author Yurguis Garcia <yurguis@gmail.com>
 */

namespace TelegramBot\Feed;

class Feed
{
    protected string $url;
    protected array $message = [];
    protected Keyword $keyword;

    public function __construct(array $feed = [])
    {
        $this->url     = $feed['url'];
        $this->message = $feed['message'];
        $this->keyword = new Keyword($feed['keyword']);
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getMessage(): array
    {
        return $this->message;
    }

    public function getKeyword(): Keyword
    {
        return $this->keyword;
    }

}