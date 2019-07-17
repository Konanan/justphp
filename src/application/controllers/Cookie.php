<?php

class CookieController extends BaseController {

    public function indexAction()
    {
        if($_COOKIE['cookietest']){
            serveJson($_COOKIE['cookietest']);
        }else{
            setcookie('cookietest',md5(time()),time()+60);
            serveJson("write cookie sucess");
        }
    }

    public function init()
    {
        disableView();
    }

}
