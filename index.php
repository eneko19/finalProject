<?php
define('__BASE_PATH__','http://localhost/finalProject/');


echo "<pre>".print_r($_POST,true)."</pre>";
echo "<br>============================================<br>";
echo "<pre>".print_r($_GET,true)."</pre>";
echo "<br>============================================<br>";
echo "<pre>".print_r($_REQUEST,true)."</pre>";
echo "<br>============================================<br>";

echo "<pre>".print_r($_SERVER,true)."</pre>";

$requestParams=explode("/",$_SERVER['REDIRECT_URL']);

echo "<pre>".print_r($requestParams,true)."</pre>";


$controllerName= isset($requestParams[2])?$requestParams[2]:NULL;
$action = isset($requestParams[3])?$requestParams[3]:NULL;
$param1 =isset($requestParams[4])?$requestParams[4]:NULL;
$param2 = isset($requestParams[5])?$requestParams[5]:NULL;
$otherParams = isset($_REQUEST)?$_REQUEST:NULL;

echo "<a href='".__BASE_PATH__."products/show/1'>Raton fornite</a>";

MainController::dispatchRequest($controllerName,$action,$param1,$param2, $otherParams);




class MainController{
    
    private static $controller = NULL;
    private static function checkUserLogged(){
        //checkear si ek usuario en Session esta logueado;
        return true;
    }
    
    public static function dispatchRequest($controllerName,$action,$param1,$param2,$otherParams){
        echo "<h1>HELLLO ENEKO</h1>";
        echo "<pre>FUNC ARGS:".print_r(func_get_args(), 1)."</pre>";
        
        
        if(!self::checkUserLogged()){
            $controllerName = "Login";
            //si quieres guardar la accion que el usuario iba hacer, despues del login lo redireccionas
        }
        
        $controllerName = is_null($controllerName)|| empty($controllerName)?"incidence":ucfirst($controllerName);
    
        $className = $controllerName."Controller";
        if(class_exists($className)){
            self::$controller = new $className();
        }else{
            self::$controller = new ErrorController();
        }
        
        /*if($controllerName=="products"){
            self::$controller = new ProductsController();
        }*/
        
        if(!is_null(self::$controller)){
            if(is_null($action) || !method_exists(self::$controller, $action)){
                $action = "viewHome";
            }
            
            
            self::$controller->$action($param1,$param2,$otherParams);
        }
        
    }
    
}


abstract class Controller{
    public abstract function index();
}

class ProductsController extends Controller {
    
    public function index(){
        echo "<h2>SOY EL INDEX DE ".__CLASS__."</h2>";
    }
    
    public function show($productId){
          echo "<h2>TE VOY A ENSEÑAR EL PRODUCTO NUMERO {$productId}</h2>";
    }
}

class AboutController{
    
    public function index(){
        echo "<h2>SOY EL INDEX DE ".__CLASS__."</h2>";
    }
}
class LoginController{
    
    public function index(){
        echo "<h2>SOY EL INDEX DE ".__CLASS__."</h2>";
    }
}

class HomeController{
    
    public function index(){
        echo "<h2>SOY EL INDEX DE ".__CLASS__."</h2>";
    }
}

class ErrorController{
    
    public function index(){
        echo "<h2>SOY EL INDEX DE ".__CLASS__."</h2>";
    }
}
class incidenceController {
    
    
    
    // Functions
    public static function viewHome() {
        require_once('app/views/home_view.phtml');
    }
}

//require_once ('db/db.php');
//require_once ('db/dbObject.php');
//require_once("controllers/incidence_controller.php");
//
//
//$controller = new incidence_controller();
//
//$controller->viewHome();

