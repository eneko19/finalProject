<?php

namespace Lookit\app\models;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LoginModel extends \dbObject {

    protected $dbTable    = "usuario";
    protected $primaryKey = "id";
    protected $dbFields   = Array(
        'id'             => Array('int'),
        'usuario'        => Array('text'),
        'password'       => Array('text'),
        'email'          => Array('text'),
        'nombre'         => Array('text'),
        'fechacreacion'  => Array('datetime'),
        'id_tipousuario' => Array('int'),
    );
    
    protected $relations  = Array(
        'tipousuarioUsu' => Array("hasOne", 'TipousuarioModel' , 'id'),
    );

    // Functions

    public function consultar_usuario() {
        $usuario  = $_POST['username'];
        $password = $_POST['password'];
        $login    = LoginModel::ArrayBuilder()->where('usuario', $usuario)->where('password', $password)->get();
        //echo "<pre>".print_r($login, 1)."</pre>";

        return $login;
    }

    public function getUser() {
        $usuario = $_SESSION['usuario'];
//         $prueba = LoginModel::with('tipousuario')->byId();
//         echo "<pre>".print_r($prueba, 1)."</pre>";die;
        $login   = LoginModel::ArrayBuilder()->where('usuario', $usuario)->get();
        //echo "<pre>".print_r($login, 1)."</pre>";

        return $login;
    }

    public function updateUser($oldPassword, $newPassword, $email, $name) {
        $usuario = $_SESSION['usuario'];

        if ($oldPassword == '') {
            $data = Array(
                'password' => $newPassword,
                'email'    => $email,
                'nombre'   => $name
            );
        } else {
            $data = Array(
                'email'  => $email,
                'nombre' => $name
            );
        }
        //die('pass' . $oldPassword);
        LoginModel::where('password', $oldPassword);
        if (LoginModel::update('usuario', $data))
            echo $db->count . ' records were updated';
        else
            echo 'update failed: ' . LoginModel::getLastError();
        //echo "<pre>".print_r($login, 1)."</pre>";
    }

    public function registerUser($user, $password, $email, $name) {
        $data    = Array(
            'usuario'        => $user,
            'password'       => $password,
            'email'          => $email,
            'nombre'         => $name,
            'id_tipousuario' => 1,
        );
        //echo "<pre>".print_r($data, 1)."</pre>";die;
        $user    = new LoginModel($data);
        $newUser = $user->save();
        
        if ($newUser == null) {
            print_r($user->errors);
        }

        return $newUser;
    }

}
