<?php

class BaseController extends Yaf_Controller_Abstract
{
    public function disableView()
    {
        Yaf_dispatcher::getInstance()->disableView();
    }

    protected function enableView()
    {
        Yaf_dispatcher::getInstance()->enableView();
    }

    protected function serveJson($data){
        $jData = json_encode($data);
        if($jData){
            exit($jData);
        }else{
            exit();
        }
    }

    protected function printRequest()
    {
        $host = $_SERVER['SERVER_NAME'];
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        if("GET" == $method){
            $query = $_SERVER['QUERY_STRING'];
        }else if("POST" == $method){
            $query = http_build_query($_POST,'&');
        }
        error_log('[' .$method.']:'.$host.$uri.'?'.$query."\n",3,'/home/data/logs/justlogs/justphp.log');
    }

    public function init()
    {
        $this->printRequest();
    }
}
