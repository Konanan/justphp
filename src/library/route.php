<?php

function includeActions()
{
    $dir = opendir(__DIR__.'/../actions');
    while(($file = readdir($dir)) !== false){
        if($file != '.' && $file != '..'){
            require('actions/'.$file);
        }
    }
}

require('base.php');
includeActions();
require('app.php');


