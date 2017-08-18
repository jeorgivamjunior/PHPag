<?php

namespace components;

use config\Main;

/**
 * Class Route
 * @package components
 * Handles URL route and params
 * Check if user is logged
 * Call importer for controller and views
 */
class Route
{
    /**
     * Redirect user to the right view, based on the route taken
     */
    public static function generate()
    {
        if (Main::$general['debug']) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }

        $params = explode('/', $_SERVER['REQUEST_URI']);
        $controller = (Main::$general['dirBase'] == '/') ? 1 : 2;
        $action = (Main::$general['dirBase'] == '/') ? 2 : 3;
        $param = (Main::$general['dirBase'] == '/') ? 3 : 4;
        if (!isset($_SESSION['userLogged']) && $params[$controller] != 'site' && $params[$action] != 'login')
            header("location:/" . ((Main::$general['dirBase'] == '/') ? '' : Main::$general['dirBase'] . "/") . "site/login");

        if (count($params) > 2) {

            if (empty($params[$controller])) {
                $params[$controller] = 'site';
                $params[$action] = 'index';
            }

            if (isset($params[$param])) {
                $_GET['id'] = $params[$param];
            }

            $class = "controllers\\" . ucfirst($params[$controller]) . "Controller";
            foreach (call_user_func($class . '::' . explode('?', $params[$action])[0]) as $key => $item) {
                $$key = $item;
            }

            if ($params[$action] != 'delete' && $params[$action] != 'logout')
                require_once("views/$params[$controller]/" . explode('?', $params[$action])[0] . ".php");
        }
    }
}