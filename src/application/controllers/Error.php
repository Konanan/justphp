<?php

class ErrorController extends Yaf_Controller_Abstract
{
    public function errorAction()
    {
        $e = $this->getRequest()->getException();
        exit("ErrorController:".$e->getMessage());
    }
}
