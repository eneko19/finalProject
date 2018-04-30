<?php

namespace Lookit\app\models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class IncidenceModel extends \dbObject {

    protected $dbTable = "incidencia";
    protected $primaryKey = "id";
    protected $dbFields = Array(
        'id' => Array('int'),
        'asunto' => Array('text'),
        'descripcion' => Array('text'),
        'fechacreacion' => Array('datetime'),
        'fechamodificacion' => Array('datetime'),
        'id_usucreacion' => Array('int'),
        'id_usuasignada' => Array('int'),
        'id_categoria' => Array('int'),
        'id_prioridad' => Array('int'),
        'id_estado' => Array('int')
    );
    protected $relations = Array(
        'userId' => Array("hasOne", "user"),
        'user' => Array("hasOne", "user", "userId")
    );

    // Functions

    public function insertInc($asunto, $descripcion, $id_usucreacion, $categoria, $prioridad) {

        $data = Array(
            'asunto' => $asunto,
            'descripcion' => $descripcion,
            'id_usucreacion' => $id_usucreacion,
            'id_categoria' => $categoria,
            'id_prioridad' => $prioridad,
            'id_estado' => 1
            );
        //echo "<pre>".print_r($data, 1)."</pre>";die;
        $inci = new IncidenceModel($data);
        $newInc = $inci->save();
        if ($newInc == null) {
            print_r($inci->errors);
        }
        //echo "<pre>".print_r($login, 1)."</pre>";

        return $newInc;
    }
    
    public function getIncNoAsign(){
        
        $inc = IncidenceModel::ArrayBuilder()->where('id_usuasignada', NULL, 'IS')->get();
        
        return $inc;
    }
    public function getIncReslt(){
        
        $inc = IncidenceModel::ArrayBuilder()->where('id_estado', 6)->get();
        
        return $inc;
    }

}
