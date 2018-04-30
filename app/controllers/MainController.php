<?php

namespace Lookit\app\controllers;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MainController
 *
 * @author eneko
 */
class MainController {

    private static $controller = NULL;

    private static function checkUserLogged() {
        //checkear si ek usuario en Session esta logueado;
        //echo "<pre>".print_r('User '.$_SESSION['usuario'], 1)."</pre>";
        if (!empty($_SESSION['usuario'])) {
            return true;
        } else {
            return false;
        }
    }

    public static function dispatchRequest($controllerName, $action, $param1, $param2, $otherParams) {
//        echo "<h1>HELLLO ENEKO</h1>";
//        echo "<pre>FUNC ARGS:".print_r(func_get_args(), 1)."</pre>";
        if (!self::checkUserLogged()) {
            $controllerName = "login";
//si quieres guardar la accion que el usuario iba hacer, despues del login lo redireccionas
        }

        $controllerName = is_null($controllerName) || empty($controllerName) ? "Incidence" : ucfirst($controllerName);

        $className = __NAMESPACE__ . "\\{$controllerName}Controller";

        if (class_exists($className)) {
            self::$controller = new $className();
        } else {
            self::$controller = new ErrorController();
        }

        /* if($controllerName=="products"){
          self::$controller = new ProductsController();
          } */

        if (!is_null(self::$controller)) {

            if (is_null($action) || !method_exists(self::$controller, $action)) {
                $action = "index";
            }

            $html = self::$controller->$action($param1, $param2, $otherParams);
        }


        echo $html;
    }

}
