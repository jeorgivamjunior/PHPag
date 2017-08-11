<?php

namespace components;

class Route
{
    public static function generate()
    {
        $params = explode('/', $_SERVER['REQUEST_URI']);
        if (!isset($_SESSION['userLogged']) && $params[2] != 'site' && $params[3] != 'login')
            header("location:/PHPag/site/login");

        if (count($params) > 2) {

            if (empty($params[2])) {
                $params[2] = 'site';
                $params[3] = 'index';
            }

            if (isset($params[4])) {
                $_GET['id'] = $params[4];
            }

            $class = "controllers\\" . ucfirst($params[2]) . "Controller";
            foreach (call_user_func($class . '::' . explode('?', $params[3])[0]) as $key => $item) {
                $$key = $item;
            }

            if ($params[3] != 'delete' && $params[3] != 'logout')
                require_once("views/$params[2]/" . explode('?', $params[3])[0] . ".php");
        }
    }
}