<?php

class ApiController extends BaseController
{
    public function indexAction()
    {
        $this->serveJson('call ApiController indexAction');
    }

    public function getVersionAction()
    {
        $data = array(
            'errno' => 1000,
            'errmsg' => '',
            'data' => 'getVersion'
        );
        $this->setData($data);
        $this->serveJson();
    }

    public function logActiveAction()
    {
        $game = $this->getValue('game');
        $platform = $this->getValue('platform');
        $deviceId = $this->getValue('deviceId');
        $data = "game=${game}&platform=${platform}&deviceId=${deviceId}";
        $this->serveJson($data);
    }

    public function init()
    {
        parent::init();
    }

}
