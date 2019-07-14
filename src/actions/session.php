<?php

class sessionAction extends baseAction
{
    public function Get()
    {
        session_start();
        if($_SESSION['username']){
            echo $_SESSION['username'] .'+' .$_SESSION['userid'];
        }else{
            $_SESSION['username'] = time();
            $_SESSION['userid'] = md5(time());
            echo "write session";
        }
    }
}
