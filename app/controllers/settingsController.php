<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Lookit\app\controllers;
use Lookit\app\models\IncidenceModel;
use Lookit\app\models\CategoriaModel;
use Lookit\app\models\PrioridadModel;
use Lookit\app\models\LoginModel;
use Lookit\app\models\ComentarioModel;

/**
 * Description of settingController
 *
 * @author eneko
 */
class settingsController {
    //put your code here
    
    public function index() {
        $template = new TemplateEngine('setting');
        
        $template->render();
    }
}
