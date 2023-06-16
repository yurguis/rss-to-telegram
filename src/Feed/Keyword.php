<?php
/**
 * @author Yurguis Garcia <yurguis@gmail.com>
 */

namespace TelegramBot\Feed;

class Keyword
{
    protected array $keywords;

    public function __construct(array $keywords = [])
    {
        $this->keywords = $keywords;
    }

    public function fields(): array
    {
        return array_keys($this->keywords);
    }

    public function matches(KeywordMatchItems $matchItems): KeywordMatchResult
    {
        $result = new KeywordMatchResult();

        foreach ($this->keywords as $key => $keyword) {
            foreach ($keyword as $item) {
                if (str_contains($matchItems->get($key), $item)) {
                    $result->setKeyword($item);
                    break 2;
                }
            }
        }

        return $result;
    }

}