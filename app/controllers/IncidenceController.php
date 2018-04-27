<?php

namespace Lookit\app\controllers;

/**
 * Description of incidence_controller
 *
 * @author eneko
 */
class IncidenceController {

    // Functions
    public function index() {


        //die('wfwef');
        $values = [
            'username' => 'enekus19',
            'user' => 'Eneko Gallego',
                //'usertype' => 'administrador'
        ];

        return (new TemplateEngine('home'))->render();

//        return (new TemplateEngine('home'))->assign('username', 'enekus19')
//                        ->assign('user', 'Eneko Gallego')
//                        ->assign('usertype', 'administrador')
//                        ->render();
//                return (new TemplateEngine('home'))->pushValues($values)
//                        ->assign('usertype', 'administrador')
//                        ->render();
    }

    public function listar() {
        $template = new TemplateEngine('incidenceList');

        return $template->render();
    }

    public function show() {
        $template = new TemplateEngine('incidence');

        return $template->render();
    }

    public function add() {
        require_once('app/views/incidenceAdd_view.phtml');
    }

}
