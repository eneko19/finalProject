<?php

namespace Lookit\app\models;
use dbObject;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PrioridadModel extends \dbObject {
    
    protected $dbTable = "prioridad";
    protected $primaryKey = "id";
    protected $dbFields = Array (
        'id' => Array('int', 'required'),
        'nombre' => Array ('text')
    );
    
    
    function showPriority() {
        
        $prio = PrioridadModel::ArrayBuilder()->get();        
        //echo "<pre>".print_r($cat, 1)."</pre>";die;
        return $prio;
    }

}