<?php
class RoutePlugin extends Plugin_Abstract
{
    public function routerShutdown(Request_Abstract $request, Response_Abstract $response){
        $controller  = $request->getControllerName();
        $controller .= ucfirst($request->getActionName());
        $params     = $request->getParams();
        $length       = count($params);
        $action       =  '';
        $i                = 1;
        foreach ($params as $key => $value) {
            if ($length == $i) {
                if (is_null($value)) {
                    $action = $key;
                } else {
                    $controller .= ucfirst($key);
                    $action      = $value;
                }
            } else {
                $controller  .= ucfirst($key).ucfirst($value);
            }
            $i++;
        }
        $request->setControllerName($controller);
        $request->setActionName($action);
    }
}

