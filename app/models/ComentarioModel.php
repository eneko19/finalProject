<?php

namespace Lookit\app\models;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ClassName extends \dbObject {

    protected $dbTable = "comentario";
    protected $primaryKey = "id";
    protected $dbFields = Array (
        'id' => Array('int', 'required'),
        'descripcion' => Array ('text'),
        'fechacreacion' => Array ('datetime'),
        'id_incidencia' => Array ('int'),
        'id_usuario' => Array ('int'),
        'id_archivo' => Array ('int')
    );
    protected $relations = Array (
        'userId' => Array ("hasOne", "user"),
        'user' => Array ("hasOne", "user", "userId")
    );

}