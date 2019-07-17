<?php

class SessionController extends Yaf_Controller_Abstract
{
    public function indexAction()
    {
        session_start();
        if($_SESSION['username']){
            exit("session:" . $_SESSION['username'] .'+' .$_SESSION['userid']);
        }else{
            $_SESSION['username'] = time();
            $_SESSION['userid'] = md5(time());
            exit("write session success");
        }
    }

    public function init()
    {
        Yaf_dispatcher::getInstance()->disableView();
    }
}
