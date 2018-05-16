<?php

namespace Lookit\app\models;

require_once ('TipousuarioModel.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LoginModel extends \dbObject {

    protected $dbTable    = "usuario";
    protected $primaryKey = "id";
    protected $dbFields   = Array(
        'usuario'        => Array('text'),
        'password'       => Array('text'),
        'email'          => Array('text'),
        'nombre'         => Array('text'),
        'fechacreacion'  => Array('datetime'),
        'id_tipousuario' => Array('int'),
    );
    protected $relations  = Array(
        'tipousuario'  => Array("hasOne", 'Lookit\app\models\TipousuarioModel', 'id_tipousuario'),
        'inciCreacion' => Array("hasMany", 'Lookit\app\models\IncidenceModel', 'id_usucreacion'),
        'inciAsginada' => Array("hasMany", 'Lookit\app\models\IncidenceModel', 'id_usuasignada'),
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

        $login = LoginModel::with('tipousuario')->where('usuario', $usuario)->getOne();
//        if($login instanceof LoginModel){
//            //echo "<pre>".print_r($login->tipousuario->nombre, 1)."</pre>";die;
//            
//        }else{
//            die("NOT LOGIN-> show error message failure login");
//        }
        return $login;
    }

    public function updateUser($user, $oldPassword, $newPassword, $email, $name) {
        $usuario = LoginModel::where('usuario', $user)->where('password', $oldPassword)->getOne();
        //echo "<pre>".print_r($usuario, 1)."</pre>";die;
        //echo($user . ' ' . ' ' .$oldPassword . ' ' .$newPassword . ' ' .$email . ' ' .$name);die;
        if ($usuario) {
            if ($newPassword != '') { // and newpass == newpassconfirm
                $usuario->password = $newPassword;
                $usuario->email    = $email;
                $usuario->nombre   = $name;
                
            } else {
                $usuario->email  = $email;
                $usuario->nombre = $name;
                
            }
            //die('pass' . $oldPassword);
            
             return $usuario->update();
            // echo "<pre>".print_r($usuario, 1)."</pre>";die;
            //echo 'wfewe'.\MysqliDb::getInstance()->getLastQuery();die;
            
           
        } else {
            echo 'ERROR';
        }
    }

    public function registerUser($user, $password, $email, $name) {
        $data    = Array(
            'usuario'        => $user,
            'password'       => $password,
            'email'          => $email,
            'nombre'         => $name,
            'id_tipousuario' => 2,
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
