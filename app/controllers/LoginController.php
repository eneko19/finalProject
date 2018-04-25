<?php

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
  
    public static function login(){
        require_once ('app/views/login_view.html');
    }
    
        public static function register(){
        require_once ('app/views/register_view.html');
    }
}
