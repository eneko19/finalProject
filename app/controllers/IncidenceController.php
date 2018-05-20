<?php

namespace Lookit\app\controllers;

use Lookit\app\models\IncidenceModel;
use Lookit\app\models\CategoriaModel;
use Lookit\app\models\PrioridadModel;
use Lookit\app\models\LoginModel;
use Lookit\app\models\ComentarioModel;

/**
 * Description of incidence_controller
 *
 * @author eneko
 */
class IncidenceController {

    // Functions
    public function index() {
        //die('wfwef');
        $values     = [
            'username' => 'enekus19',
            'user'     => 'Eneko Gallego',
                //'usertype' => 'administrador'
        ];
        //echo "<pre>".print_r($_SESSION['iduser'], 1)."</pre>";
//        return (new TemplateEngine('home'))->assign('username', 'enekus19')
//                        ->assign('user', 'Eneko Gallego')
//                        ->assign('usertype', 'administrador')
//                        ->render();
//                return (new TemplateEngine('home'))->pushValues($values)
//                        ->assign('usertype', 'administrador')
//                        ->render();
        $template   = new TemplateEngine('home');
        $usuario    = new LoginModel();
        $incidencia = new IncidenceModel();

        $usu        = $usuario->getUser();
        $incNoAsign = $incidencia->getIncNoAsign();
        $incReslt   = $incidencia->getIncReslt();
        $incAsignMi = $incidencia->getIncAsignMi();
        $incModif   = $incidencia->getIncModif();
        $incRepMi   = $incidencia->getIncRepMi();

        $valores = [
            'usuario' => $usu,
            'noAsign' => $incNoAsign,
            'reslt'   => $incReslt,
            'asignMi' => $incAsignMi,
            'modif'   => $incModif,
            'repMi'   => $incRepMi
        ];

        //echo "<pre>".print_r($template->pushValues($valores), 1)."</pre>";die;

        return $template->pushValues($valores)->render();
    }

    public function listar() {
        $template = new TemplateEngine('incidenceList');
        $usuario  = new LoginModel();
        $inci     = new IncidenceModel();

        $usu    = $usuario->getUser();
        $allInc = $inci->getIncAll();

        $valores = [
            'usuario'     => $usu,
            'incidencias' => $allInc
        ];


        return $template->pushValues($valores)->render();
    }

    public function show() {
        $id       = func_get_arg(0);
        //echo "<pre>".print_r($id, 1)."</pre>";die;
        $template = new TemplateEngine('incidence');
        $usuario  = new LoginModel();
        $inci     = new IncidenceModel();
        $coments  = new ComentarioModel();

        $usu = $usuario->getUser();
        $inc = $inci->getInc($id);
        $com = $coments->getComents($id);

        $valores = [
            'usuario'    => $usu,
            'incidencia' => $inc,
            'comentario' => $com
        ];

        //echo "<pre>" . print_r($valores, 1) . "</pre>";die;
        return $template->pushValues($valores)->render();
    }

    public function add() {
        $template  = new TemplateEngine('incidenceAdd');
        $categoria = new CategoriaModel();
        $prioridad = new PrioridadModel();
        $usuario   = new LoginModel();

        $cat  = $categoria->showCategories();
        $prio = $prioridad->showPriority();
        $usu  = $usuario->getUser();

        $valores = ['categoria' => $cat, 'prioridad' => $prio, 'usuario' => $usu];


        return $template->pushValues($valores)->render();
    }

    public function insert() {
        $incidencia = new IncidenceModel();

        $asunto         = $_POST['asunto'];
        $descripcion    = $_POST['descripcion'];
        $id_usucreacion = $_POST['usucreacion'];
        $categoria      = $_POST['categoria'];
        $prioridad      = $_POST['prioridad'];

        $incidencia->insertInc($asunto, $descripcion, $id_usucreacion, $categoria, $prioridad);
        
        $url = base_url().'';
        header('Location:'. $url .'');
    }

    public function search() {
        $idIncidencia = $_POST['idInci'];

        $url = base_url().'incidence/show/'.$idIncidencia.'';
        header('Location:'. $url .'');
    }

}
