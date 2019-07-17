<?php

class HostController extends BaseController
{
    public function indexAction()
    {
        $this->serveJson($_SERVER);
    }

    public function init()
    {
        $this->disableView();
        parent::init();
    }
}
