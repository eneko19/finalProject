<?php

namespace Lookit\app\models;

use dbObject;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CategoriaModel extends \dbObject {

    protected $dbTable = "categoria";
    protected $primaryKey = "id";
    protected $dbFields = Array(
        'nombre' => Array('text')
    );
    protected $relations = Array(
        'incidencia' => Array("hasMany", "Lookit\app\models\IncidenceModel", "id_categoria"),
    );

    function showCategories() {

        $cat = CategoriaModel::ArrayBuilder()->get();
        //echo "<pre>".print_r($cat, 1)."</pre>";die;
        return $cat;
    }

}
