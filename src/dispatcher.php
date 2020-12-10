<?php
require_once 'business.php';
function dispatch($routing, $action_url)
{
    $controller_name = $routing[$action_url];
    $model = [];
    $view_name = $controller_name($model);
    build_response($view_name, $model);
}

function build_response($view_name, $model){
    if (strpos($view_name, 'redirect:') === 0) {
        $url = substr($view_name, strlen('redirect:'));
        header("Location: " . $url);
        exit;
    } else {
        render($view_name, $model);
    }
}
function render($view_name,$model){
    extract($model);
    include 'view/'.$view_name.'.php';
}