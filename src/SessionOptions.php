<?php

namespace Ions\Session;

use Ions\Std\AbstractOptions;

/**
 * Class SessionOptions
 * @package Ions\Session
 */
class SessionOptions extends AbstractOptions
{
    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        if (!preg_match('/^[a-zA-Z0-9]+$/', $name)) {
            throw new \InvalidArgumentException('Name provided contains invalid characters; must be alphanumeric only');
        }

        ini_set('session.name', $name);

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return ini_get('session.name');
    }

    /**
     * @param $savePath
     * @return $this
     */
    public function setPath($savePath)
    {
        if (!is_dir($savePath)) {
            throw new \InvalidArgumentException('Invalid save_path provided; not a directory');
        }

        if (!is_writable($savePath)) {
            throw new \InvalidArgumentException('Invalid save_path provided; not writable');
        }

        ini_set('session.save_path', $savePath);

        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return ini_get('session.save_path');
    }

    /**
     * @param $gcProbability
     * @return $this
     */
    public function setGcProbability($gcProbability)
    {
        $gcProbability = (int)$gcProbability;

        if (0 > $gcProbability || 100 < $gcProbability) {
            throw new \InvalidArgumentException('Invalid gc_probability; must be a percentage');
        }

        ini_set('session.gc_probability', $gcProbability);

        return $this;
    }

    /**
     * @return string
     */
    public function getGcProbability()
    {
        return ini_get('session.gc_probability');
    }

    /**
     * @param $gcDivisor
     * @return $this
     */
    public function setGcDivisor($gcDivisor)
    {
        $gcDivisor = (int)$gcDivisor;

        if (1 > $gcDivisor) {
            throw new \InvalidArgumentException('Invalid gc_divisor; must be a positive integer');
        }

        ini_set('session.gc_divisor', $gcDivisor);

        return $this;
    }

    /**
     * @return string
     */
    public function getGcDivisor()
    {
        return ini_get('session.gc_divisor');
    }

    /**
     * @param $gcMaxlifetime
     * @return $this
     */
    public function setLifetime($gcMaxlifetime)
    {
        $gcMaxlifetime = (int)$gcMaxlifetime;

        if (1 > $gcMaxlifetime) {
            throw new \InvalidArgumentException('Invalid gc_maxlifetime; must be a positive integer');
        }

        ini_set('session.gc_maxlifetime', $gcMaxlifetime);

        return $this;
    }

    /**
     * @return string
     */
    public function getLifetime()
    {
        return ini_get('session.gc_maxlifetime');
    }

    /**
     * @param $cookieLifetime
     * @return $this
     */
    public function setCookieLifetime($cookieLifetime)
    {
        if (0 > $cookieLifetime) {
            throw new \InvalidArgumentException('Invalid cookie_lifetime; must be a positive integer or zero');
        }

        ini_set('session.cookie_lifetime', (int)$cookieLifetime);

        return $this;
    }

    /**
     * @return string
     */
    public function getCookieLifetime()
    {
        return ini_get('session.cookie_lifetime');
    }

    /**
     * @param $cookiePath
     * @return $this
     */
    public function setCookiePath($cookiePath)
    {
        $cookiePath = (string)$cookiePath;

        $path = parse_url($cookiePath, PHP_URL_PATH);

        if ($path !== $cookiePath || '/' !== $path[0]) {
            throw new \InvalidArgumentException('Invalid cookie path');
        }

        ini_set('session.cookie_path', $cookiePath);

        return $this;
    }

    /**
     * @return string
     */
    public function getCookiePath()
    {
        return ini_get('session.cookie_path');
    }

    /**
     * @param $cookieDomain
     * @return $this
     */
    public function setCookieDomain($cookieDomain)
    {
        if (!is_string($cookieDomain)) {
            throw new \InvalidArgumentException('Invalid cookie domain: must be a string');
        }

        ini_set('session.cookie_domain', $cookieDomain);

        return $this;
    }

    /**
     * @return string
     */
    public function getCookieDomain()
    {
        return ini_get('session.cookie_domain');
    }

    /**
     * @param $cookieSecure
     * @return $this
     */
    public function setCookieSecure($cookieSecure)
    {
        ini_set('session.cookie_secure', (bool)$cookieSecure);

        return $this;
    }

    /**
     * @return string
     */
    public function getCookieSecure()
    {
        return ini_get('session.cookie_secure');
    }

    /**
     * @param $cookieHttpOnly
     * @return $this
     */
    public function setCookieHttpOnly($cookieHttpOnly)
    {
        ini_set('session.cookie_httponly', (bool)$cookieHttpOnly);

        return $this;
    }

    /**
     * @return string
     */
    public function getCookieHttpOnly()
    {
        return ini_get('session.cookie_httponly');
    }

    /**
     * @param $useCookies
     * @return $this
     */
    public function setUseCookies($useCookies)
    {
        ini_set('session.use_cookies', (bool)$useCookies);

        return $this;
    }

    /**
     * @return string
     */
    public function getUseCookies()
    {
        return ini_get('session.use_cookies');
    }
}
