<?php

namespace Lookit\app\models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TipousuarioModel extends \dbObject {

    protected $dbTable    = "usuario";
    protected $primaryKey = "id";
    protected $dbFields   = Array(
        'id'     => Array('int'),
        'nombre' => Array('text'),
    );
    protected $relations = Array(
        'usuario' => Array("hasOne", "id", 'id_tipousuario'),
    );

    // Functions
}
