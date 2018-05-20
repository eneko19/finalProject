<?php

namespace Lookit\app\controllers;

use Lookit\app\models\ComentarioModel;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginController
 *
 * @author eneko
 */
class ComentarioController {

    public function index() {

    }

    public function add() {
        
        $desc  = $_POST['desc'];
        $idInc = func_get_arg(0);
        $idUser = func_get_arg(1);
        $file = $_POST['file'];
        
        $com = new ComentarioModel();
        
        $com->addComent($desc, $idInc, $idUser);
        
        $url = base_url().'incidence/show/'.$idInc.'';
        header('Location:'. $url .'');
    }



}
