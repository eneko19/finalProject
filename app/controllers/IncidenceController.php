<?php

namespace Lookit\app\controllers;

use Lookit\app\models\IncidenceModel;
use Lookit\app\models\CategoriaModel;
use Lookit\app\models\PrioridadModel;
use Lookit\app\models\LoginModel;

/**
 * Description of incidence_controller
 *
 * @author eneko
 */
class IncidenceController {

    // Functions
    public function index() {

        //die('wfwef');
        $values = [
            'username' => 'enekus19',
            'user' => 'Eneko Gallego',
                //'usertype' => 'administrador'
        ];

//        return (new TemplateEngine('home'))->assign('username', 'enekus19')
//                        ->assign('user', 'Eneko Gallego')
//                        ->assign('usertype', 'administrador')
//                        ->render();
//                return (new TemplateEngine('home'))->pushValues($values)
//                        ->assign('usertype', 'administrador')
//                        ->render();
        $template = new TemplateEngine('home');
        $usuario = new LoginModel();
        $incidencia = new IncidenceModel();

        $usu = $usuario->getUser();
        $incNoAsign = $incidencia->getIncNoAsign();
        $incReslt = $incidencia->getIncReslt();

        $valores = ['usuario' => $usu, 'noAsign' => $incNoAsign, 'reslt' => $incReslt];

        //echo "<pre>".print_r($template->pushValues($valores), 1)."</pre>";die;
        return $template->pushValues($valores)->render();
    }

    public function listar() {
        $template = new TemplateEngine('incidenceList');
        $usuario = new LoginModel();

        $usu = $usuario->getUser();

        $valores = ['usuario' => $usu];


        return $template->pushValues($valores)->render();
    }

    public function show() {
        $template = new TemplateEngine('incidence');
        $usuario = new LoginModel();

        $usu = $usuario->getUser();

        $valores = ['usuario' => $usu];


        return $template->pushValues($valores)->render();
    }

    public function add() {
        $template = new TemplateEngine('incidenceAdd');
        $categoria = new CategoriaModel();
        $prioridad = new PrioridadModel();
        $usuario = new LoginModel();

        $cat = $categoria->showCategories();
        $prio = $prioridad->showPriority();
        $usu = $usuario->getUser();

        $valores = ['categoria' => $cat, 'prioridad' => $prio, 'usuario' => $usu];


        return $template->pushValues($valores)->render();
    }

    public function insert() {
        $incidencia = new IncidenceModel();

        $asunto = $_POST['asunto'];
        $descripcion = $_POST['descripcion'];
        $id_usucreacion = $_POST['usucreacion'];
        $categoria = $_POST['categoria'];
        $prioridad = $_POST['prioridad'];

        $incidencia->insertInc($asunto, $descripcion, $id_usucreacion, $categoria, $prioridad);
    }

}
