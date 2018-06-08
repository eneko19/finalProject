<?php

namespace Lookit\app\models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class IncidenceModel extends \dbObject {

    protected $dbTable    = "incidencia";
    protected $primaryKey = "id";
    protected $dbFields   = Array(
        'asunto'            => Array('text'),
        'descripcion'       => Array('text'),
        'fechacreacion'     => Array('datetime'),
        'fechamodificacion' => Array('datetime'),
        'id_usucreacion'    => Array('int'),
        'id_usuasignada'    => Array('int'),
        'id_categoria'      => Array('int'),
        'id_prioridad'      => Array('int'),
        'id_estado'         => Array('int')
    );
    protected $relations  = Array(
        'usuarioCreacion' => Array("hasOne", "Lookit\app\models\LoginModel", "id_usucreacion", 'uc'),
        'usuarioAsignado' => Array("hasOne", "Lookit\app\models\LoginModel", "id_usuasignada", 'ua'),
        'categoria'       => Array("hasOne", "Lookit\app\models\CategoriaModel", "id_categoria"),
        'prioridad'       => Array("hasOne", "Lookit\app\models\PrioridadModel", "id_prioridad"),
        'estado'          => Array("hasOne", "Lookit\app\models\EstadoModel", "id_estado"),
        'comentario'      => Array("hasMany", "Lookit\app\models\ComentarioModel", "id_incidencia"),
        'historial'       => Array("hasMany", "Lookit\app\models\HistorialModel", "id_incidence")
    );

    // Functions

    public function insertInc($asunto, $descripcion, $id_usucreacion, $categoria, $prioridad) {

        $data   = Array(
            'asunto'         => $asunto,
            'descripcion'    => $descripcion,
            'id_usucreacion' => $id_usucreacion,
            'id_categoria'   => $categoria,
            'id_prioridad'   => $prioridad,
            'id_estado'      => 1
        );
        //echo "<pre>".print_r($data, 1)."</pre>";die;
        $inci   = new IncidenceModel($data);
        $newInc = $inci->save();
        if ($newInc == null) {
            print_r($inci->errors);
        }

        return $newInc;
    }

    public function getIncNoAsign() {
        $inc = IncidenceModel::where('id_usuasignada', NULL, 'IS')->orderBy("fechamodificacion ", "desc")->get(Array(0, 5));
        //echo "<pre>".print_r($inc, 1)."</pre>";
        return $inc;
    }

    public function getIncNoAsignCount() {
        $inc = IncidenceModel::where('id_usuasignada', NULL, 'IS')->count();
        return $inc;
    }

    public function getIncReslt() {
        $inc = IncidenceModel::orderBy("fechamodificacion", "desc")->where('id_estado', 6)->get(Array(0, 5));

        return $inc;
    }

    public function getIncResltCount() {
        $inc = IncidenceModel::where('id_estado', 6)->count();
        return $inc;
    }

    public function getIncAsignMi() {
        $userAsign = $_SESSION['iduser'];
        $inc       = IncidenceModel::where('id_usuasignada', $userAsign)->orderBy("fechamodificacion ", "desc")->get(Array(0, 5));

        return $inc;
    }

    public function getIncAsignMiCount() {
        $userAsign = $_SESSION['iduser'];
        $inc       = IncidenceModel::where('id_usuasignada', $userAsign)->count();
        return $inc;
    }

    public function getIncRepMi() {
        $userAsign = $_SESSION['iduser'];
        $inc       = IncidenceModel::where('id_usucreacion', $userAsign)->orderBy("fechamodificacion", "desc")->get(Array(0, 5));

        return $inc;
    }

    public function getIncRepMiCount() {
        $userAsign = $_SESSION['iduser'];
        $inc       = IncidenceModel::where('id_usucreacion', $userAsign)->count();
        return $inc;
    }

    public function getIncModif() {
        $fiveDaysAgo = date('Y-m-d', strtotime('-5 days', strtotime(date('Y-m-d'))));
        $inc         = IncidenceModel::where('fechamodificacion', $fiveDaysAgo, '>=')->orderBy("fechamodificacion", "desc")->orderBy("fechamodificacion ", "desc")->get(Array(0, 5));
        //echo "<pre>".print_r('No hay nada '.$inc, 1)."</pre>";die;
        return $inc;
    }

    public function getIncModifCount() {
        $fiveDaysAgo = date('Y-m-d', strtotime('-5 days', strtotime(date('Y-m-d'))));
        $inc         = IncidenceModel::where('fechamodificacion', $fiveDaysAgo, '>=')->count();
        return $inc;
    }

    public function getIncAll() {
        $inc = IncidenceModel::with('usuarioCreacion')->with('usuarioAsignado')->orderBy("fechamodificacion ", "desc")->get();
        //echo "<pre>".print_r('No hay nada '.$inc, 1)."</pre>";die;
        return $inc;
    }

    public function getInc($id) {
        $inc = IncidenceModel::with('usuarioCreacion')->with('usuarioAsignado')->where('incidencia.id', $id)->getOne();
        //echo "<pre>".print_r('No hay nada '.$inc, 1)."</pre>";die;

        return $inc;
    }

    // Filtros
    public function getAllIncNoAsign() {
        $inc = IncidenceModel::where('id_usuasignada', NULL, 'IS')->orderBy("fechamodificacion ", "desc")->get();

        return $inc;
    }

    public function getAllIncReslt() {
        //$inc = IncidenceModel::ArrayBuilder()->where('id_estado', 6)->get();
        $inc = IncidenceModel::where('id_estado', 6)->get();

        return $inc;
    }

    public function getAllIncAsignMi() {
        $userAsign = $_SESSION['iduser'];
        $inc       = IncidenceModel::where('id_usuasignada', $userAsign)->orderBy("fechamodificacion ", "desc")->get();

        return $inc;
    }

    public function getAllIncRepMi() {
        $userAsign = $_SESSION['iduser'];
        $inc       = IncidenceModel::where('id_usucreacion', $userAsign)->get();

        return $inc;
    }

    public function getAllIncModif() {
        $fiveDaysAgo = date('Y-m-d', strtotime('-5 days', strtotime(date('Y-m-d'))));
        $inc         = IncidenceModel::where('fechamodificacion', $fiveDaysAgo, '>=')->orderBy("fechamodificacion", "desc")->orderBy("fechamodificacion ", "desc")->get();
        //echo "<pre>".print_r('No hay nada '.$inc, 1)."</pre>";die;
        return $inc;
    }

    public function chgUsuarioAsignado($idInc, $idUsuAsign) {
        $inc = IncidenceModel::where('id', $idInc)->getOne();

        $inc->id_usuasignada    = $idUsuAsign;
        $inc->id_estado         = 5;
        $inc->fechamodificacion = date("Y-m-d H:i:s");

        return $inc->update();
    }

    public function chgEstado($idInc, $idEstado) {
        $inc = IncidenceModel::where('id', $idInc)->getOne();

        $inc->id_estado         = $idEstado;
        $inc->fechamodificacion = date("Y-m-d H:i:s");

        return $inc->update();
    }

}
