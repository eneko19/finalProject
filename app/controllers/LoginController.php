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
        return $this->login();
    }

    public function login() {
        require_once ('app/views/login_view.html');
    }

    public function register() {
        require_once ('app/views/register_view.html');
    }

    public function view() {

        $template = new TemplateEngine('user');

        return $template->render();
    }

}
