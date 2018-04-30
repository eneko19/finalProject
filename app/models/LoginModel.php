<?php

namespace Lookit\app\models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LoginModel extends \dbObject {

    protected $dbTable = "usuario";
    protected $primaryKey = "id";
    protected $dbFields = Array(
        'id' => Array('int', 'required'),
        'usuario' => Array('text'),
        'password' => Array('text'),
        'email' => Array('text'),
        'nombre' => Array('text'),
        'fechacreacion' => Array('datetime'),
        'id_tipousuario' => Array('int'),
    );
    protected $relations = Array(
        'userId' => Array("hasOne", "user"),
        'user' => Array("hasOne", "user", "userId")
    );

    // Functions

    public function consultar_usuario() {
        $usuario = $_POST['username'];
        $password = $_POST['password'];
        $login = LoginModel::ArrayBuilder()->where('usuario', $usuario)->where('password', $password)->get();
        //echo "<pre>".print_r($login, 1)."</pre>";

        return $login;
    }

    public function getUser() {
        $usuario = $_SESSION['usuario'];
        $login = LoginModel::ArrayBuilder()->where('usuario', $usuario)->get();
        //echo "<pre>".print_r($login, 1)."</pre>";

        return $login;
    }

}
