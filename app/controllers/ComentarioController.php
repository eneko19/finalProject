<?php

namespace Lookit\app\controllers;

use Lookit\app\models\ComentarioModel;
use Lookit\app\models\HistorialModel;

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
        $com = new ComentarioModel();
        $his = new HistorialModel();

        $desc   = $_POST['desc'];
        $idInc  = func_get_arg(0);
        $idUser = func_get_arg(1);
        $file   = $_POST['file'];


        $com->addComent($desc, $idInc, $idUser);
        $his->newHis($idUser, $idInc, 2, 'Nuevo comentario', NULL, NULL);

        $url = base_url() . 'incidence/show/' . $idInc . '';
        header('Location:' . $url . '');
    }

}
