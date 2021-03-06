<?php

namespace Lookit\app\controllers;

use Lookit\app\models\LoginModel;
use Lookit\app\models\IncidenceModel;

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
class LoginController {

    public function index() {
        //return $this->login();
        $template = new TemplateEngine('login');

        if (isset($_SESSION['failureLogin'])) {
            $valores = ['loginFailure' => $_SESSION['failureLogin']];
            return $template->pushValues($valores)->render();
        }

        return $template->render();
    }

    public function login() {
        $login = new LoginModel();

        $username = !empty($_POST['username']) ? $_POST['username'] : "";
        $password = !empty($_POST['password']) ? $_POST['password'] : "";
        //$password_encriptada = md5($password);

        if (empty($_POST['username']) || empty($_POST['password'])) {
            $template = new TemplateEngine('login');
            $valores  = [
                'userempty' => empty($_POST['username']),
                'passempty' => empty($_POST['password'])
            ];
            return $template->pushValues($valores)->render();
        }


        $ok = $login->consultar_usuario();
        if ($ok) {
            $_SESSION['usuario'] = $username;
            unset($_SESSION['failureLogin']);
        } else {
            $_SESSION['failureLogin'] += 1;
        }

        $incidence = new IncidenceController();

        $url = base_url() . '';
        header('Location:' . $url . '');
    }

    public function register() {
        $template = new TemplateEngine('register');

        return $template->render();
    }

    public function view() {

        $template = new TemplateEngine('user');
        $usuario  = new LoginModel();

        $usu = $usuario->getUser();

        $valores = ['usuario' => $usu];

        return $template->pushValues($valores)->render();
    }

    public function update() {
        $usuario = new LoginModel();

        $user        = $_POST['usuario'];
        $oldPassword = $_POST['passActual'];
        $newPassword = $_POST['passNuevaConf'];
        $email       = $_POST['email'];
        $name        = $_POST['nombre'];

        $usuario->updateUser($user, $oldPassword, $newPassword, $email, $name);
        
        $url = base_url() . '';
        header('Location:' . $url . 'login/view');
    }
    
    // Borra un usuario
    public function delete(){
        $id = func_get_arg(0);
        $usuario = new LoginModel();
        
        $usuario->deleteUser($id);
        
        $url = base_url() . '';
        header('Location:' . $url . 'settings');
    }

    public function registerUser() {
        $usuario = new LoginModel();

        $user     = $_POST['username'];
        $password = $_POST['password'];
        $email    = $_POST['email'];
        $name     = $_POST['name'];

        $usuario->registerUser($user, $password, $email, $name);

        $url = base_url() . '';
        header('Location:' . $url . '');
    }

    /**
     * Finaliza la sesión de usuario
     */
    function logout() {
        // Borra contingut de $_SESSION
        unset($_SESSION['usuario']);

        $url = base_url() . '';
        header('Location:' . $url . '');
    }
    

}
