<?php

namespace Ions\Session\Handler;

/**
 * Class File
 * @package Ions\Session\Handler
 */
class File implements \SessionHandlerInterface
{
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $path;

    /**
     * @param string $path
     * @param string $name
     * @return bool
     */
    public function open($path, $name)
    {
        $this->name = $name;
        $this->path = $path;

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
     * @param string $session_id
     * @return array|bool|string
     */
    public function read($session_id)
    {
        $file = $this->path . '/sess_' . basename($session_id);

        if (is_file($file)) {
            $handle = fopen($file, 'rb');

            flock($handle, LOCK_SH);

            $data = fread($handle, filesize($file));

            flock($handle, LOCK_UN);

            fclose($handle);

            return $data;
        }

        return '';
    }

    /**
     * @param string $session_id
     * @param string $data
     * @return bool
     */
    public function write($session_id, $data)
    {
        $file = $this->path . '/sess_' . basename($session_id);

        $handle = fopen($file, 'wb');

        flock($handle, LOCK_EX);

        fwrite($handle, $data);

        fflush($handle);

        flock($handle, LOCK_UN);

        fclose($handle);

        return true;
    }

    /**
     * @param string $id
     * @return void
     */
    public function destroy($id)
    {
        $file = $this->path . '/sess_' . basename($id);

        if (is_file($file)) {
            unset($file);
        }
    }

    /**
     * @param int $maxlifetime
     * @return bool
     */
    public function gc($maxlifetime)
    {
        $files = glob($this->path . '/sess_*');

        foreach ($files as $file) {
            if ((time() - filemtime($file)) > $maxlifetime) {
                unlink($file);
            }
        }

        return true;
    }

    /**
     * @return void
     */
    public function __destruct()
    {
        $lifetime = ini_get('session.gc_maxlifetime');
        $this->gc($lifetime);
    }
}
