<?php

class app
{
    //Get / Post
    private $method = null;
    //Action Name
    private $actionName = null;
    //Action Method
    private $actionMethod = null;
    //action object
    private $action = null;


    public function Run()
    {
        $this->DoParams();
        $this->DoAction();
        $this->DoRoute();
    }

    public function DoParams()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];

        $uri = explode('/',$_SERVER['REQUEST_URI']);
        if(count($uri) > 1){
            $this->actionName = $uri[1];
        }
        if(count($uri) > 2){
            $this->actionMethod = $uri[2];
        }
    }

    public function DoRoute()
    {
        if('GET' == $this->method){
            $this->action->Get();
        }else if('POST' == $this->method){
            $this->action->Post();
        }
    }

    public function DoAction()
    {
        $className = $this->actionName . "Action";
        $this->action = new $className;
    }
}
