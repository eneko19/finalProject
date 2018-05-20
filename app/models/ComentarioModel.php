<?php

namespace Lookit\app\models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ComentarioModel extends \dbObject {

    protected $dbTable    = "comentario";
    protected $primaryKey = "id";
    protected $dbFields   = Array(
        'descripcion'   => Array('text'),
        'fechacreacion' => Array('datetime'),
        'id_incidencia' => Array('int'),
        'id_usuario'    => Array('int'),
        'id_archivo'    => Array('int')
    );
    protected $relations  = Array(
        'incidencia' => Array("hasOne", "Lookit\app\models\IncidenceModel", 'id_incidencia'),
        'usuario'    => Array("hasOne", "Lookit\app\models\LoginModel", "id_usuario")
    );

    // Funciones

    public function getComents($idInc) {
        $comments = ComentarioModel::where('id_incidencia', $idInc)->get();

        return $comments;
    }

    public function addComent($desc,$idInc,$idUser) {
        $data    = Array(
            'descripcion'        => $desc,
            'id_incidencia'       => $idInc,
            'id_usuario'          => $idUser,
            'id_archivo'          => NULL,
        );
        //echo "<pre>".print_r($data, 1)."</pre>";die;
        $com    = new ComentarioModel($data);
        $newComent = $com->save();
        
        return $newComent;
    }

}
