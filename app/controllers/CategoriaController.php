<?php

namespace Lookit\app\controllers;

use Lookit\app\models\CategoriaModel;

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
class CategoriaController {

    public function index() {
        
    }

    public function add() {

        $name = $_POST['nombre'];
        $desc = $_POST['desc'];

        $cat = new CategoriaModel();

        $cat->addCategory($name, $desc);

        $url = base_url() . 'settings';
        header('Location:' . $url . '');
    }

    // Borra una categoría
    public function delete() {
        $id      = func_get_arg(0);
        $cat = new CategoriaModel();

        $cat->deleteCat($id);

        $url = base_url() . 'settings';
        header('Location:' . $url);
    }

}
