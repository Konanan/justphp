<?php

class HostController extends BaseController
{
    public function indexAction()
    {
        $this->serveJson($_SERVER);
    }

    public function apiAction()
    {
        $host = $this->getHost();
        $uri = $this->getUri();
        $var1 = $this->getValue('var1');
        $method = '';
        if($this->isGet()){
            $method = 'GET';
        }else if($this->isPost()){
            $method = 'POST';
        }else{
            $method = $this->getMothed();
        }
        $this->setData(array(
            'host' => $host,
            'uri' => $uri,
            'method' => $method,
            'var1' => $var1
        ));
        $this->serveJson();
    }

    public function viewAction()
    {
        $this->serveHtml(array('servers' => $_SERVER));
    }

    public function view2Action()
    {
        $this->setTplName('host/view22.phtml');
        $this->setData(array('servers' => $_SERVER));
        $this->serveHtml();
    }

    public function init()
    {
        parent::init();
    }
}
