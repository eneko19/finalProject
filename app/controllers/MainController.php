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

    //checkea si el usuario en Session esta logueado;
    private static function checkUserLogged() {
        if (!empty($_SESSION['usuario'])) {
            return true;
        } else {
            return false;
        }
    }

    // Función que redirije al controlador y la accion mediante datos cogidos de la URL.
    public static function dispatchRequest($controllerName, $action, $param1, $param2, $otherParams) {
        if (!self::checkUserLogged()) {
            $controllerName = "login";
            
        }


        $controllerName = is_null($controllerName) || empty($controllerName) ? "Incidence" : ucfirst($controllerName);

        $className = __NAMESPACE__ . "\\{$controllerName}Controller";

        if (class_exists($className)) {
            self::$controller = new $className();
        } else {
            self::$controller = new ErrorController();
        }

        // Siempre que no haya una acción manda al index del controllador
        if (!is_null(self::$controller)) {

            if (is_null($action) || !method_exists(self::$controller, $action)) {
                $action = "index";
            }

            $html = self::$controller->$action($param1, $param2, $otherParams);
        }


        echo $html;
    }

}
