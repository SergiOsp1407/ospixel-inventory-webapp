<?php 
require_once 'config/Config.php';
$route = (!empty($_GET['url'])) ? $_GET['url'] : 'home/index';
$array = explode('/', $route);
$controller = ucfirst($array[0]);
$method = 'index';
$param = '';

if (!empty($array[1])) {
    if ($array[1] != '') {
        $method = $array[1];
    }
}
if (!empty($array[2])) {
    if ($array[2] != '') {
        for ($i=2; $i < count($array); $i++) { 
            $param .= $array[$i] . ',';
        }
        $param = trim($param, ',');
    }
}

require_once 'config/app/Autoload.php';
$dirController = 'controllers/' . $controller . '.php';
if (file_exists($dirController)) {
    require_once $dirController;
    $controller = new $controller();
    if (method_exists($controller,$method)) {
        $controller->$method($param);
    }else {
        echo 'The method doesn`t exists ';
    }
}else {
    echo 'The controller doesn`t exists ';
}


?>