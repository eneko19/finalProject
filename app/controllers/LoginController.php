<?php

namespace Lookit\app\controllers;


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

        return $template->render();
    }

    public function login() {
        $login = new LoginModel();

        $username = !empty($_POST['username']) ? $_POST['username'] : "";
        $password = !empty($_POST['password']) ? $_POST['password'] : "";
        //$password_encriptada = md5($password);

        $ok = $login->consultar_usuario();
        if ($ok) {
            $_SESSION['usuario'] = $username;
        }
        $incidence = new IncidenceController();
        return $incidence->index();
    }

    public function register() {
        $template = new TemplateEngine('register');

        return $template->render();
    }

    public function view() {

        $template = new TemplateEngine('user');
        $usuario = new LoginModel();

        $usu = $usuario->getUser();

        $valores = ['usuario' => $usu];

        return $template->pushValues($valores)->render();
    }
    public function update() {
        $usuario = new LoginModel();
        
        $oldPassword = $_POST['passActual'];
        $newPassword = $_POST['passNuevaConf'];
        $email = $_POST['email'];
        $name = $_POST['nombre'];
        
        $usuario->updateUser($oldPassword, $newPassword, $email, $name);
    }
    public function registerUser() {
        $usuario = new LoginModel();
        
        $user = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $name = $_POST['name'];
        
        $usuario->registerUser($user, $password, $email, $name);
    }

    /**
     * Finaliza la sesión de usuario
     */
    function logout() {
        // Borra contingut de $_SESSION
        unset($_SESSION['usuario']);
        // elimina la sessio
    }

}
