<?php
class MemcacheSvc
{
    const FLAG_NO = false;
    const FLAG_YES = true;
    const NODATA_EXPIRE = 60;
    const EXPIRE_TIME = 36000;

    private $_ins = null;
    private $_flag = null;

    public function __construct($servers, $flag = self::FLAG_NO)
    {
        $this->_ins = new Memcache();
        $this->logger = Logger::ins();
        foreach ($servers as $s) {
            $this->_ins->addServer($s['host'], $s['port']);
        }
        $this->_flag = $flag;
    }

    static public function ins($config = 'default')
    {
        $logger = Logger::ins();
        $servers = array();
        if ($config == 'pay') {
            $servers[] = array('host' => $_SERVER['MEMCACHE_PAY_HOST'], 'port' => $_SERVER['MEMCACHE_PAY_PORT']);
        } else {
            $servers[] = array('host' => $_SERVER['MEMCACHE_HOST'], 'port' => $_SERVER['MEMCACHE_PORT']);
        }
        try {
            $memSvc = new MemcacheSvc($servers);
        } catch (exception $e) {
            $logger->error("[" . __CLASS__ . "],[" . __FUNCTION__ . "], [exception msg=" . $e->getMessage() . "]");
            throw new exception ($e);
        }
        return $memSvc;
    }

    public function get($key)
    {
        return $this->_ins->get($key);
    }

    public function set($key, $value, $expire)
    {
        $this->logger->info("key=$key,expire=$expire");
        return $this->_ins->set($key, $value, $this->_flag, $expire);
    }

    public function add($key, $value, $expire)
    {
        return $this->_ins->add($key, $value, $this->_flag, $expire);
    }

    public function delete($key)
    {
        return $this->_ins->delete($key);
    }

    public function flush()
    {
        return $this->_ins->flush();
    }

    public function increment($key, $value)
    {
        return $this->_ins->increment($key, $value);
    }

    public function decrement($key, $value)
    {
        return $this->_ins->decrement($key, $value);
    }

    public function update($key, $value)
    {
        $value = (int)$value;
        if ($value > 0) {
            return $this->increment($key, $value);
        }
        return $this->decrement($key, abs($value));
    }

    public function close()
    {
        return $this->_ins->close();
    }

    public function __destruct()
    {
        $this->close();
    }
}
