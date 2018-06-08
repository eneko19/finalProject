<?php

namespace Lookit\app\controllers;

use Lookit\app\models\IncidenceModel;
use Lookit\app\models\CategoriaModel;
use Lookit\app\models\PrioridadModel;
use Lookit\app\models\LoginModel;
use Lookit\app\models\ComentarioModel;
use Lookit\app\models\EstadoModel;
use Lookit\app\models\HistorialModel;

/**
 * Description of incidence_controller
 *
 * @author eneko
 */
class IncidenceController {

    // Functions
    public function index() {
        $template   = new TemplateEngine('home');
        $usuario    = new LoginModel();
        $incidencia = new IncidenceModel();
        $his        = new HistorialModel();

        $usu             = $usuario->getUser();
        $incNoAsign      = $incidencia->getIncNoAsign();
        $incNoAsignCount = $incidencia->getIncNoAsignCount();
        $incReslt        = $incidencia->getIncReslt();
        $incResltCount   = $incidencia->getIncResltCount();
        $incAsignMi      = $incidencia->getIncAsignMi();
        $incAsignMiCount = $incidencia->getIncAsignMiCount();
        $incModif        = $incidencia->getIncModif();
        $incModifCount   = $incidencia->getIncModifCount();
        $incRepMi        = $incidencia->getIncRepMi();
        $incRepMiCount   = $incidencia->getIncRepMiCount();
        $historial       = $his->getAllHis();

        $valores = [
            'usuario'      => $usu,
            'noAsign'      => $incNoAsign,
            'reslt'        => $incReslt,
            'asignMi'      => $incAsignMi,
            'modif'        => $incModif,
            'repMi'        => $incRepMi,
            'historial'    => $historial,
            'countNoAsign' => $incNoAsignCount,
            'countReslt'   => $incResltCount,
            'countAsignMi' => $incAsignMiCount,
            'countModif'   => $incModifCount,
            'countRepMi'   => $incRepMiCount,
        ];

        //echo "<pre>".print_r($incNoAsign, 1)."</pre>";die;

        return $template->pushValues($valores)->render();
    }

    public function listar() {
        $filter   = func_get_arg(0);
        $text     = '';
        //echo "<pre>".print_r($filter, 1)."</pre>";die;
        $template = new TemplateEngine('incidenceList');
        $usuario  = new LoginModel();
        $inci     = new IncidenceModel();

        $usu = $usuario->getUser();

        switch ($filter) {
            case 'no-asignadas':
                $allInc = $inci->getAllIncNoAsign();
                $text   = 'no asignadas';
                break;
            case 'reportadas':
                $allInc = $inci->getAllIncRepMi();
                $text   = 'reportadas por mi';
                break;
            case 'resueltas':
                $allInc = $inci->getAllIncReslt();
                $text   = 'resueltas';
                break;
            case 'modificadas-recientemente':
                $allInc = $inci->getAllIncModif();
                $text   = 'modificadas recientemente';
                break;
            case 'asignadas':
                $allInc = $inci->getAllIncAsignMi();
                $text   = 'asignadas';
                break;
            default:
                $allInc = $inci->getIncAll();
                break;
        }

        $valores = [
            'usuario'     => $usu,
            'incidencias' => $allInc
        ];


        return $template->pushValues($valores)->assign('texto', $text)->render();
    }

    public function show() {
        $id       = func_get_arg(0);
        //echo "<pre>".print_r($id, 1)."</pre>";die;
        $template = new TemplateEngine('incidence');
        $usuario  = new LoginModel();
        $inci     = new IncidenceModel();
        $coments  = new ComentarioModel();
        $estado   = new EstadoModel();
        $his      = new HistorialModel();

        $usu       = $usuario->getUser();
        $allUsers  = $usuario->getAllUsers();
        $inc       = $inci->getInc($id);
        $com       = $coments->getComents($id);
        $estados   = $estado->getAllEstados();
        $historial = $his->getHis($id);

        $valores = [
            'usuario'    => $usu,
            'allUsers'   => $allUsers,
            'incidencia' => $inc,
            'comentario' => $com,
            'estados'    => $estados,
            'historial'  => $historial
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

        $valores = [
            'categoria' => $cat,
            'prioridad' => $prio,
            'usuario'   => $usu
        ];


        return $template->pushValues($valores)->render();
    }

    public function insert() {
        $incidencia = new IncidenceModel();
        $historial  = new HistorialModel();

        $idUsu          = $_SESSION['iduser'];
        $asunto         = $_POST['asunto'];
        $descripcion    = $_POST['descripcion'];
        $id_usucreacion = $_POST['usucreacion'];
        $categoria      = $_POST['categoria'];
        $prioridad      = $_POST['prioridad'];
        $insertInc      = $incidencia->insertInc($asunto, $descripcion, $id_usucreacion, $categoria, $prioridad);

        $historial->newHis($idUsu, $insertInc, 1, 'Nueva incidencia', NULL, NULL);

        $url = base_url() . '';
        header('Location:' . $url . '');
    }

    public function search() {
        $idIncidencia = $_POST['idInci'];

        $url = base_url() . 'incidence/show/' . $idIncidencia . '';
        header('Location:' . $url . '');
    }

    /* Cambia el usuario asigando de una asistencia */

    public function chgUsuAsign() {
        $inc = new IncidenceModel();
        $his = new HistorialModel();

        $usuAsign   = explode('|', $_POST['usuarioAsignado']);
        $idUsu      = $_SESSION['iduser'];
        $idInc      = func_get_arg(0);
        $oldValue   = func_get_arg(1);
        $newValue   = $usuAsign[1];
        $idUsuAsign = $usuAsign[0];

        $inc->chgUsuarioAsignado($idInc, $idUsuAsign);
        $his->newHis($idUsu, $idInc, 3, 'Usuario asignado', $oldValue, $newValue);

        $url = base_url() . 'incidence/show/' . $idInc;
        header('Location:' . $url);
    }

    /* Cambia el usuario asigando de una asistencia */

    public function chgEstado() {
        $inc = new IncidenceModel();
        $his = new HistorialModel();

        $estado   = explode('|', $_POST['estado']);
        $idInc    = func_get_arg(0);
        $idEstado = $estado[0];
        $oldValue = func_get_arg(1);
        $newValue = $estado[1];
        $idUsu    = $_SESSION['iduser'];

        $inc->chgEstado($idInc, $idEstado);
        $his->newHis($idUsu, $idInc, 4, 'Estado', $oldValue, $newValue);

        $url = base_url() . 'incidence/show/' . $idInc;
        header('Location:' . $url);
    }

}
