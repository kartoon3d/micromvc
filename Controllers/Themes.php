<?php
class Themes extends Controller
{
    public function __construct()
    {
    }

    public static function Settings($view, $params)
    {
        require_once(__DIR__ . '../../vendor/autoload.php');
        $loader = new Twig\Loader\FilesystemLoader('Views/' . self::$admin_theme . '/');
        $twig = new Twig\Environment($loader);
        if ($_SESSION["user"] > 0) {
            if (strpos($_GET["url"], '/') !== false) {
                $url = explode("/", $_GET["url"]);
                $view = $url[1];
            }
            echo $twig->render('index.html.twig');
        } else if (!isset($_SESSION["user"])) {
            echo $twig->render('login.html.twig');
        }
    }
    
}
