<?php
class Logger
{
    private $prefix;
    private $app;
    static $ins = null;
    static $ins_dc = null;
    static $trance = array('error', 'err', 'debug');
    static $testLog = array('debug', 'warning');
    const ONLINE_ENV = 'online';
    const LOG_PATH = '/home/data/logs/project/';

    public function __construct($app)
    {
        $this->app = $app;
    }

    private function setApp($app)
    {
        $this->app = $app;
    }

    static public function ins()
    {
        if (self::$ins == null) {
            $app = $_SERVER['PRJ_NAME'];
            $cls = __CLASS__;
            self::$ins = new $cls($app);
        }
        return self::$ins;
    }

    private function createPath($path)
    {
        return is_dir($path) or ($this->createPath(dirname($path)) and mkdir($path));
    }

    private function write_log($level, $msg)
    {
        if ($_SERVER['ENV'] == self::ONLINE_ENV && in_array($level, self::$testLog))
            return;
        $flag = 'php';
        if ($flag === 'php') {
            $prj = $_SERVER['PRJ_NAME'];
            $app = $prj . "/" . date("Y/m/d") . "/";
            $path = self::LOG_PATH . $app;
            $this->createPath($path);
            $path = $path . date("H") . ".log";
            $msg = date("Y-m-d H:i:s") . " $prj [$level],[$msg]";
            error_log($msg . "\n", 3, $path);
        } else {
            $msg = '[' . str_replace(array("\r", "\n"), '', $msg) . ']';
            openlog($this->app, LOG_CONS | LOG_PID, LOG_LOCAL6);
            if (in_array($level, self::$trance)) {
                $bt = debug_backtrace(true);
                $c_file = basename($bt[$this->backtrace_depth + 1]['file']);
                $c_line = $bt[$this->backtrace_depth + 1]['line'];
                $c_class = $bt[$this->backtrace_depth + 2]['class'];
                $c_func = $bt[$this->backtrace_depth + 2]['function'];
                $func_str = "{$c_class}::{$c_func} ";
                $msg .= ",[{$func_str},file:{$c_file},line:{$c_line}]";
            }
            syslog($this->getSysLevel($level), "[$level]," . $msg);
        }
    }

    private function getSysLevel($level)
    {

        switch ($level) {
            case 'debug':
                $level = LOG_DEBUG;
                break;
            case 'info':
                $level = LOG_INFO;
                break;
            case 'log':
                $level = LOG_INFO;
                break;
            case 'warning':
                $level = LOG_WARNING;
                break;
            case 'error':
                $level = LOG_ERR;
                break;
            default:
                $level = LOG_INFO;
        }
        return $level;
    }

    public function log($msg)
    {
        $this->write_log('log', $msg);
    }

    public function info($msg)
    {
        $this->write_log('info', $msg);
    }

    public function err($msg)
    {
        $this->write_log('error', $msg);
    }

    public function warning($msg)
    {
        $this->write_log('warning', $msg);
    }

    public function error($msg)
    {
        $this->write_log('error', $msg);
    }

    public function debug($msg)
    {
        $this->write_log('debug', $msg);
    }

    static public function mark($msg, $level = 'info')
    {
        Logger::ins()->$level($msg, $level);
    }

    static public function proDclog()
    {
        if (self::$ins_dc == null) {
            $app = 'dc_sdk';
            $cls = __CLASS__;
            self::$ins_dc = new $cls($app);
        }
        return self::$ins_dc;
    }
}

