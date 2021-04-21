<?php
class Controller extends Db
{
    public function __construct()
    {
    }

    public static function View($view)
    {
        require_once(__DIR__ . '../../vendor/autoload.php');
        $loader = new Twig\Loader\FilesystemLoader('Views/' . self::$default_theme . '/');
        $twig = new Twig\Environment($loader);
        if (!file_exists('Views/' . self::$default_theme . '/' . $view . '.html.twig')) {
            return "Error loading template file ($view).";
        }
        if (file_exists('Views/' . self::$default_theme . '/' . $view . '.html.twig')) {
            echo $twig->render($view . '.html.twig');
        }
    }

    public static function Protect($view)
    {
        if ($_SESSION["user"] > 0) {
            require_once('Views/' . self::$admin_theme . '/index.html.twig');
        } else if (!isset($_SESSION["user"])) {
            require_once('Views/' . self::$admin_theme . '/login.html.twig');
        }
    }
    
}
