<?php
/**
 * @author Yurguis Garcia <yurguis@gmail.com>
 */

namespace TelegramBot\Cache;

use ErrorException;
use LogicException;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\MemcachedAdapter;
use Symfony\Component\Cache\Exception\CacheException;

class Client
{
    protected AdapterInterface $adapter;

    /**
     * @throws CacheException
     * @throws ErrorException
     */
    public function __construct(array $config = [])
    {
        if ($config['cache']['adapter'] === 'memcached') {
            $client = MemcachedAdapter::createConnection([
                $config['cache']['provider']
            ]);

            $this->adapter = new MemcachedAdapter(
                $client,
                $config['cache']['namespace'],
                $config['cache']['default_lifetime']
            );
        } elseif ($config['cache']['adapter'] === 'filesystem') {
            $this->adapter = new FilesystemAdapter(
                $config['cache']['namespace'],
                $config['cache']['default_lifetime']
            );
        } else {
            throw new LogicException("Cache Adapter '{$config['cache']['adapter']}' is not supported!");
        }
    }

    public function getAdapter(): AdapterInterface
    {
        return $this->adapter;
    }

}