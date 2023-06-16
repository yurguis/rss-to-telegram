<?php
/**
 * @author Yurguis Garcia <yurguis@gmail.com>
 */

namespace TelegramBot\Feed;

class KeywordMatchItems
{
    protected array $items;

    public function add(string $key, string $content): void
    {
        $this->items[$key] = $content;
    }

    public function get(string $item): ?string
    {
        return $this->items[$item] ?? null;
    }

}