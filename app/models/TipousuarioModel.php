<?php

namespace Lookit\app\models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TipousuarioModel extends \dbObject {

    protected $dbTable    = "tipousuario";
    protected $primaryKey = "id";
    protected $dbFields   = Array(
        'nombre' => Array('text'),
    );
    protected $relations = Array(
        'usuarios' => Array("hasMany", "Lookit\app\models\LoginModel", 'id_tipousuario'),
    );

    // Functions
}
