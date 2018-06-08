<?php

namespace Lookit\app\models;

use dbObject;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HistorialModel extends \dbObject {

    protected $dbTable    = "historial";
    protected $primaryKey = "id";
    protected $dbFields   = Array(
        'id_user'           => Array('int'),
        'id_incidence'      => Array('int'),
        'type'      => Array('int'),
        'nombre'            => Array('text'),
        'old_value'         => Array('text'),
        'new_value'         => Array('text'),
        'fechamodificacion' => Array('date')
    );
    protected $relations  = Array(
        'usuarioCreacion' => Array("hasOne", "Lookit\app\models\LoginModel", "id_user"),
        'incidencia'      => Array("hasOne", "Lookit\app\models\IncidenceModel", "id_incidence"),
    );

    // Functions
    
    public function getAllHis(){
        $his = HistorialModel::orderBy('fechamodificacion', 'DESC')->get();
        
        return $his;
    }
    public function getHis($idInc){
        $his = HistorialModel::where('id_incidence',$idInc)->get();
        
        return $his;
    }

    public function newHis($idUsu, $idInc, $type, $nombre, $oldValue, $newValue) {
        $data   = Array(
            'id_user'      => $idUsu,
            'id_incidence' => $idInc,
            'nombre'       => $nombre,
            'type'       => $type,
            'old_value'    => $oldValue,
            'new_value'    => $newValue
        );
        $his    = new HistorialModel($data);
        $newHis = $his->save();

        return $newInc;
    }

}
