<?php

namespace Ions\Session;

/**
 * Class Session
 * @package Ions\Session
 */
class Session implements SessionInterface
{
    /**
     * @var SessionOptions $options
     */
    protected $options;
    /**
     * @var $data
     */
    protected $data;

    /**
     * Session constructor.
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = new SessionOptions($options);
    }

    /**
     * @return void
     */
    public function start()
    {
        session_start();
        $this->data = &$_SESSION;
    }

    /**
     * @return void
     */
    public function destroy()
    {
        session_destroy();
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->data[$key];
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value)
    {
        return $this->data[$key] = $value;
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        session_id($id);

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return session_id();
    }

    /**
     * @param bool $delete
     * @return $this
     */
    public function regenerateId($delete = true)
    {
        session_regenerate_id((bool)$delete);
        return $this;
    }

    /**
     * @param $saveHandler
     * @return bool
     */
    public function registerSaveHandler($saveHandler)
    {
        return session_set_save_handler($saveHandler);
    }
}
