<?php
class Admin extends Controller
{
    public function __construct()
    {
    }

    public static function Login()
    {
        require_once(__DIR__ . '../../vendor/autoload.php');
        $loader = new Twig\Loader\FilesystemLoader('Views/' . self::$admin_theme . '/');
        $twig = new Twig\Environment($loader);
        if ($_SESSION["user"] > 0) {
            echo $twig->render('index.html.twig');
        } else if (!$_SESSION["user"] > 0) {
            $dbh = new PDO('mysql:dbname=' . self::$database . ';host=' . self::$host . '', self::$username, self::$password);
            $email = $_POST['email'];
            $password = $_POST['password'];
            if (isset($_POST) && $email != '' && $password != '') {
                $sql = $dbh->prepare("SELECT id,password,psalt,username FROM users WHERE email=?");
                $sql->execute(array($email));
                while ($r = $sql->fetch()) {
                    $p = $r['password'];
                    $p_salt = $r['psalt'];
                    $id = $r['id'];
                    $username = $r['username'];
                }
                $site_salt = self::$site_salt;
                $salted_hash = hash('sha256', $password . $site_salt . $p_salt);
                if ($p == $salted_hash) {
                    $_SESSION['user'] = $id;
                    $_SESSION['username'] = $username;
                    echo $twig->render('index.html.twig');
                } else if ($p != $salted_hash) {
                    echo $twig->render('login.html.twig');
                }
            }
        }
    }

    public static function Register()
    {
        $dbh = new PDO('mysql:dbname=' . self::$database . ';host=' . self::$host . '', self::$username, self::$password);
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $password = $_POST['password'];
            $sql = $dbh->prepare("SELECT COUNT(*) FROM `users` WHERE `email`=?");
            $sql->execute(array($_POST['email']));
            if ($sql->fetchColumn() != 0) {
                die("User Exists");
            } else {
                function rand_string($length)
                {
                    $str = "";
                    $chars = "abcdefghijklmanopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                    $size = strlen($chars);
                    for ($i = 0; $i < $length; $i++) {
                        $str .= $chars[rand(0, $size - 1)];
                    }
                    return $str;
                }
                $p_salt = rand_string(20);
                $site_salt = self::$site_salt;
                $salted_hash = hash('sha256', $password . $site_salt . $p_salt);
                $sql = $dbh->prepare("INSERT INTO `users` (`id`, `email`, `username`,`password`, `psalt`) VALUES (NULL, ?, ?, ?, ?);");
                $sql->execute(array($_POST['email'], $_POST['username'], $salted_hash, $p_salt));
                echo "Successfully Registered.";
                require_once('Views/' . self::$admin_theme . '/login.php');
                die();
            }
        }
    }
    
    public static function Logout()
    {
        session_destroy();
        require_once(__DIR__ . '../../vendor/autoload.php');
        $loader = new Twig\Loader\FilesystemLoader('Views/' . self::$admin_theme . '/');
        $twig = new Twig\Environment($loader);
        echo $twig->render('login.html.twig');
    }
}
