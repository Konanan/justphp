<?php


class cookieAction extends baseAction
{
    public function Get()
    {
        if($_COOKIE['cookietest']){
            echo $_COOKIE['cookietest'];
        }else{
            setcookie('cookietest',md5(time()),time()+60);
            echo "write cookie";
        }
    }
}
