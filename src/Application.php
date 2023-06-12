<?php
/**
 * @author Yurguis Garcia <yurguis@gmail.com>
 */

namespace TelegramBot;

use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    public function __construct(iterable $commands, string $version = 'UNKNOWN')
    {
        parent::__construct('RSS to Telegram', $version);

        foreach ($commands as $command) {
            $this->add($command);
        }
    }

}