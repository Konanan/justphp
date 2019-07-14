<?php

class hostAction extends baseAction
{
    public function Post(){
        exit('host Post');
    }

    public function Get()
    {
        $userAgent = '';
        foreach($_SERVER as $k => $v){
            $userAgent .= "$k=$v<br>";
        }
        echo "$userAgent<br>";
    }
}
