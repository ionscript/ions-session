<?php

namespace Ions\Session\Handler;

use Ions\Cache\CacheInterface;

/**
 * Class Cache
 * @package Ions\Session\Handler
 */
class Cache implements \SessionHandlerInterface
{
    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * Cache constructor.
     * @param CacheInterface $cache
     */
    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param string $path
     * @param string $name
     * @return bool
     */
    public function open($path, $name)
    {
        return true;
    }

    /**
     * @return bool
     */
    public function close()
    {
        return true;
    }

    /**
     * @param string $id
     * @return string
     */
    public function read($id)
    {
        return (string)$this->cache->get($id);
    }

    /**
     * @param string $id
     * @param string $data
     * @return mixed
     */
    public function write($id, $data)
    {
        return $this->cache->set($id, $data);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function destroy($id)
    {
        return (bool)$this->cache->remove($id);
    }

    /**
     * @param int $maxlifetime
     * @return bool
     */
    public function gc($maxlifetime)
    {
        $this->cache->clearExpired();

        return true;
    }
}
