<?php

namespace Ions\Session\Handler;

/**
 * Class Db
 * @package Ions\Session\Handler
 */
class Db implements \SessionHandlerInterface
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
     * @var
     */
    private $maxlifetime;

    /**
     * Db constructor.
     * @param \Ions\Db\Db $db
     */
    public function __construct(\Ions\Db\Db $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $path
     * @param string $name
     * @return bool
     */
    public function open($path, $name)
    {
        $this->name = $name;
        $this->path = $path;

        $this->maxlifetime = ini_get('session.gc_maxlifetime');

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
     * @return bool
     */
    public function read($id)
    {
        $query = $this->db->query('SELECT `data` FROM `session` WHERE id = ' . $this->db->escape($id) . ' AND `name` = ' . $this->db->escape($this->name) . ' AND `expire` > ' . (int)time());

        if ($query->count) {
            return $query->row['data'];
        }

        return '';
    }

    /**
     * @param string $id
     * @param string $data
     * @return bool
     */
    public function write($id, $data)
    {
        if ($id) {
            $this->db->execute('REPLACE INTO `session` SET id = ' . $this->db->escape($id) . ', `name` = ' . $this->db->escape($this->name) . ', `data` = ' . $this->db->escape($data) . ', expire = ' . $this->db->escape(date('Y-m-d H:i:s', time() + $this->maxlifetime)));
        }

        return true;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function destroy($id)
    {
        $this->db->execute('DELETE FROM `session` WHERE id = ' . $this->db->escape($id) . ' AND `name` = ' . $this->db->escape($this->name));

        return true;
    }

    /**
     * @param int $maxlifetime
     * @return bool
     */
    public function gc($maxlifetime)
    {
        $this->db->execute('DELETE FROM `session` WHERE `expire` < '. ((int)time() + $this->maxlifetime));

        return true;
    }

//    /**
//     * @return bool
//     */
//    public function __destruct()
//    {
//        $this->gc($this->maxlifetime);
//
//        return true;
//    }
}
