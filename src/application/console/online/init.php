<?php
define("APPLICATION_PATH",  '/home/data/system/chxRoute/src/');
 class GlobalApplicaion
 {
    static $application = null;
    static public function ins()
    {
        if ( ! self::$application = Yaf_Registry::get('Application') ) {
            self::$application = new Yaf_Application(APPLICATION_PATH . "conf/console.ini",'product');
            Yaf_Registry::set('Application', self::$application);
        }
        return self::$application;
    }
 }

$_SERVER['ENV']='online';
$_SERVER['PRJ_NAME']='chxRoute';


GlobalApplicaion::ins();
Yaf_Dispatcher::getInstance()->catchException(false);
