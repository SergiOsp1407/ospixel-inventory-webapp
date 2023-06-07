<?php
class Views{
    public function getView($route, $name, $data = ""){

        if ($route == 'main') {
            $view = 'views/' . $name . '.php';
        }else {
            $view = 'views/' . $route . '/' . $name . '.php';
        }
        require $view;
        
    }
}


?>