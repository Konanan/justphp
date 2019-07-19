<?php

class BaseController extends Yaf_Controller_Abstract
{
    //模板名字
    private $tplName = null;
    //返回数据
    private $data = null;

    /***
     * Request操作
     */

    protected function isPost(){
        return $this->getRequest()->isPost();
    }

    protected function isGet(){
        return $this->getRequest()->isGet();
    }

    protected function getHost(){
        return $this->getRequest()->getServer('SERVER_NAME');
    }

    protected function getIp(){
        return $this->getRequest()->getServer('REMOTE_ADDR');
    }

    protected function getUri(){
        return $this->getRequest()->getServer('REQUEST_URI');
    }

    protected function getActionName(){
        return $this->getRequest()->getActionName();
    }

    protected function getMethod(){
        return $this->getRequest()->getMethod();
    }

    // POST or GET or COOKIE or SERVER
    public function getValue($key){
        return $this->getRequest()->get($key);
    }


    /***
     * View操作
     */

    public function hideView(){
        Yaf_dispatcher::getInstance()->disableView();
    }

    protected function showView(){
        Yaf_dispatcher::getInstance()->enableView();
    }

    protected function setTplName($tpl){
        $this->tplName = $tpl;
    }

    protected function setData($data){
        if(is_array($data) || is_string($data)){
            $this->data = $data;
        }
    }

    protected function serveJson($data = null){
        //禁止渲染页面
        $this->hideView();

        if(is_array($data) || is_string($data)){
            $this->data = $data;
        }
        //array成json，string直接输出
        if(is_array($this->data)){
            $jData = json_encode($this->data);
            if($jData){
                $this->markResponse($jData);
                exit($jData);
            }
        }else if(is_string($this->data)){
            $this->markResponse($this->data);
            exit($this->data);
        }
        exit();
    }

    protected function serveHtml($data = null){
        //开启页面渲染
        $this->showView();

        if(is_array($data)){
            $this->data = $data;
        }

        if(is_array($this->data)){
            foreach($this->data as $k => $v){
                $this->getView()->assign($k,$v);
            }
            if(is_string($this->tplName) && '' != $this->tplName){
                //渲染别的页面后要禁用自动渲染，否则会重复渲染
                $this->getView()->display($this->tplName);
                $this->hideView();
            }
        }
        $this->markResponse(json_encode($this->data));
    }

    protected function markRequest(){
        $ctler = $this->getRequest()->getControllerName();
        $action = $this->getActionName();
        $host = $this->getHost();
        $uri = $this->getUri();
        $method = $this->getMethod();
        $ip = $this->getIp();

        if("GET" == $method){
            $query = $_SERVER['QUERY_STRING'];
        }else if("POST" == $method){
            $query = http_build_query($_POST,'&');
        }
        $log = "Request=${ctler}_${action}&Info=${method}:${host}${uri}?${query}&Ip=${ip}";
        error_log($log."\n",3,'/home/data/logs/justlogs/justphp.log');
    }

    protected function markResponse($data){
        $ctler = $this->getRequest()->getControllerName();
        $action = $this->getActionName();
        $host = $this->getHost();
        $uri = $this->getUri();
        $method = $this->getMethod();
        $ip = $this->getIp();

        $log = "Response=${ctler}_${action}&Info=${method}:${host}${uri}&Ret=${data}";
        error_log($log."\n",3,'/home/data/logs/justlogs/justphp.log');
    }

    public function init(){
        $this->markRequest();
    }
}
