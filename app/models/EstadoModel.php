<?php

namespace Lookit\app\models;

use dbObject;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EstadoModel extends \dbObject {

    protected $dbTable    = "estado";
    protected $primaryKey = "id";
    protected $dbFields   = Array(
        'nombre' => Array('text')
    );
    protected $relations  = Array(
        'incidencia' => Array("hasMany", "Lookit\app\models\IncidenceModel", "id_estado"),
    );

    // Functions

    public function getAllEstados() {
        $estados = EstadoModel::get();

        return $estados;
    }

}
