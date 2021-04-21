<?php
class Route extends Db
{
    public static $routes = array();

    public static function get($route, $function)
    {
        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') !== 0) {
            return;
        }
        $params=null;
        if(strpos($route, '/') !== false){
            $url=explode("/", $route);
            $route=$url[0];
            $url_c = explode('/',$_GET['url']);
            $params=$url_c[1];
        }
        self::go($route,$params,$function);
    }

    public static function post($route, $function){
    if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') !== 0) {
        return;
    }  
    if(strpos($route, '/') !== false){
        $url=explode("/", $route);
        $route=$url[0];
        $url_c = explode('/',$_GET['url']);
        $params=$url_c[1];
    }
    self::go($route,$params,$function);
    }

    public static function go($route,$params,$function){
        self::$routes[] = $route;
        $url_c = explode('/',$_GET['url']);
        if ($url_c[0] == $route) {
            call_user_func($function,$params);
            exit;
        }
    }

    public static function fallback()
    {
        if (!in_array($_GET['url'], self::$routes)) {
            require_once('Views/'.self::$default_theme.'/404.html.twig');
            exit;
        }
    }
    
}
