<?php if (!session_id()) {session_start();}

require_once(__DIR__.'/Routes.php');

function __autoload($class_name)
{

    if (file_exists(('./classes/' . $class_name . '.php'))) {
        require_once('./classes/' . $class_name . '.php');
    } else if (file_exists(('./Controllers/' . $class_name . '.php'))) {
        require_once('./Controllers/' . $class_name . '.php');
    } else if (file_exists(('./plugins/'.$class_name.'/' . $class_name . '.php'))) {
        require_once('./plugins/'.$class_name.'/' . $class_name . '.php');
    }
}
?>
