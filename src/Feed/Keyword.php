<?php
/**
 * @author Yurguis Garcia <yurguis@gmail.com>
 */

namespace TelegramBot\Feed;

class Keyword
{
    protected array $title;
    protected array $description;

    public function __construct(array $keyword = [])
    {
        $this->title = $keyword['title'] ?? [];
        $this->description = $keyword['description'] ?? [];
    }

    public function matches(string $title, string $description): bool
    {
        foreach ($this->title as $keyword) {
            if (false !== strpos($title, $keyword)) {
                return true;
            }
        }

        foreach ($this->description as $keyword) {
            if (false !== strpos($description, $keyword)) {
                return true;
            }
        }

        return false;
    }

}