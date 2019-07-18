<?php

class ErrorController extends Yaf_Controller_Abstract
{
    public function errorAction()
    {
        $e = $this->getRequest()->getException();
        exit("捕获到报错<br>ErrorController<br>".$e->getMessage());
    }
}
