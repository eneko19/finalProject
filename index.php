<?php

require_once 'vendor/autoload.php';
use Lookit\app\controllers\TemplateEngine;
use Lookit\app\controllers\MainController;

//define('__BASE_PATH__','http://localhost/finalProject/');

//require_once("app/controllers/MainController.php");
//require_once("app/controllers/IncidenceController.php");
//require_once("app/controllers/ErrorController.php");
//require_once("app/controllers/LoginController.php");

if (!function_exists('base_url')) {
    function base_url($atRoot=FALSE, $atCore=FALSE, $parse=FALSE){
        if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

            $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
            $core = $core[0];

            $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
            $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
            $base_url = sprintf( $tmplt, $http, $hostname, $end );
        }
        else $base_url = 'http://localhost/';

        if ($parse) {
            $base_url = parse_url($base_url);
            if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
        }

        return $base_url;
    }
}


//function autoload($className)
//{
////list comma separated directory name
//$directory = array('app/controllers/', 'app/models/', 'app/views/', '');
//
////list of comma separated file format
//$fileFormat = array('%s.php', '%s.class.php');
//
//foreach ($directory as $current_dir)
//{
//    foreach ($fileFormat as $current_format)
//    {
//
//        $path = $current_dir.sprintf($current_format, $className);
//        if (file_exists($path))
//        {
//            //echo 'Encontrado' . $path;
//            require_once $path;
//            return ;
//        }
//    }
//}
//}
//spl_autoload_register('autoload');


TemplateEngine::setTemplatesPath(dirname(__FILE__).'/app/views/');
//echo "<pre>".print_r($_POST,true)."</pre>";
//echo "<br>============================================<br>";
//echo "<pre>".print_r($_GET,true)."</pre>";
//echo "<br>============================================<br>";
//echo "<pre>".print_r($_REQUEST,true)."</pre>";
//echo "<br>============================================<br>";

//echo "<pre>".print_r($_SERVER,true)."</pre>";

$requestParams=explode("/",$_SERVER['REDIRECT_URL']);

//echo "<pre>".print_r($requestParams,true)."</pre>";


$controllerName= isset($requestParams[2])?$requestParams[2]:NULL;
$action = isset($requestParams[3])?$requestParams[3]:NULL;
$param1 =isset($requestParams[4])?$requestParams[4]:NULL;
$param2 = isset($requestParams[5])?$requestParams[5]:NULL;
$otherParams = isset($_REQUEST)?$_REQUEST:NULL;

//echo "<a href='".__BASE_PATH__."products/show/1'>Raton fornite</a>";

MainController::dispatchRequest($controllerName,$action,$param1,$param2, $otherParams);



//require_once ('db/db.php');
//require_once ('db/dbObject.php');
//require_once("controllers/incidence_controller.php");
//
//
//$controller = new incidence_controller();
//
//$controller->viewHome();

