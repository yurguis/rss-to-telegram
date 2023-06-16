<?php
/**
 * @author Yurguis Garcia <yurguis@gmail.com>
 */

namespace TelegramBot\Feed;

class KeywordMatchResult
{
    protected bool $match = false;
    protected string $keyword;

    public function getKeyword(): string
    {
        return $this->keyword;
    }

    public function setKeyword(string $keyword): void
    {
        $this->match   = true;
        $this->keyword = $keyword;
    }

    public function isMatch(): bool
    {
        return $this->match;
    }

     public function setMatch(bool $match): void
    {
        $this->match = $match;
    }
}