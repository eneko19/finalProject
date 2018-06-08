<?php

namespace Lookit\app\controllers;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ErrorContoller
 *
 * @author eneko
 */

class ErrorController{

    public function index(){
        $template = new TemplateEngine('error404');
        
        return $template->render();
    }
}
