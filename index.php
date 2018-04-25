<?php
define('__BASE_PATH__','http://localhost/finalProject/');

require_once("app/controllers/MainController.php");
require_once("app/controllers/IncidenceController.php");
require_once("app/controllers/ErrorController.php");

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

