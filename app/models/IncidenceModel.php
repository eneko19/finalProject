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
        'usuarioCreacion' => Array("hasOne", "Lookit\app\models\LoginModel", "id_usucreacion"),
        'usuarioAsignado' => Array("hasOne", "Lookit\app\models\LoginModel", "id_usuasignada"),
        'categoria' => Array("hasOne", "Lookit\app\models\CategoriaModel", "id_categoria"),
        'prioridad' => Array("hasOne", "Lookit\app\models\PrioridadModel", "id_prioridad"),
        'estado' => Array("hasOne", "Lookit\app\models\estado", "id_estado"),
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
        $inc = IncidenceModel::ArrayBuilder()->where('id_usuasignada', NULL, 'IS')->get(Array (0, 5));
        
        return $inc;
    }
    public function getIncReslt(){
        //$inc = IncidenceModel::ArrayBuilder()->where('id_estado', 6)->get();
        //$inc = IncidenceModel::with('usuarioCreacion')->get();
       $inc = IncidenceModel::where('id_estado', 6)->get();
        foreach ($inc as $i) {
            echo "ASSUNTO: {$i->asunto} => UC:{$i->usuarioCreacion->nombre} UA: {$i->usuarioAsignado->nombre}<br><br>";
        }
        
        echo "<pre>".print_r($inc, 1)."</pre>";die;
        
        return $inc;
    }
    public function getIncAsignMi(){
        $userAsign = $_SESSION['iduser'];
        $inc = IncidenceModel::ArrayBuilder()->where('id_usuasignada', $userAsign)->get();
        
        return $inc;
    }
    public function getIncRepMi(){
        $userAsign = $_SESSION['iduser'];
        $inc = IncidenceModel::ArrayBuilder()->where('id_usucreacion', $userAsign)->get();
        
        return $inc;
    }
    public function getIncModif(){
        $fiveDaysAgo = date('Y-m-d', strtotime('-5 days', strtotime(date('Y-m-d'))));
        $inc = IncidenceModel::ArrayBuilder()->where('fechamodificacion', $fiveDaysAgo, '>=')->orderBy("fechamodificacion","desc")->get();
        //echo "<pre>".print_r('No hay nada '.$inc, 1)."</pre>";die;
        return $inc;
    }
    public function getIncAll(){
        $inc = IncidenceModel::ArrayBuilder()->orderBy("fechamodificacion","desc")->get();
        //echo "<pre>".print_r('No hay nada '.$inc, 1)."</pre>";die;
        return $inc;
    }
    public function getInc($id){
        $inc = IncidenceModel::ArrayBuilder()->where('id', $id)->get();
        //echo "<pre>".print_r('No hay nada '.$inc, 1)."</pre>";die;
        return $inc;
    }

}
