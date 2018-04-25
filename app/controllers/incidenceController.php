<?php

/**
 * Description of incidence_controller
 *
 * @author eneko
 */
class IncidenceController {

    // Functions
    public static function view() {
        require_once('app/views/home_view.phtml');
    }

    public static function incidenceView() {
        require_once('app/views/incidence_view.phtml');
    }

    // Prueba
    public function index() {
        echo "<h2>SOY EL INDEX DE " . __CLASS__ . "</h2>";
    }

    public function show($productId) {
        echo "<h2>TE VOY A ENSEÑAR EL PRODUCTO NUMERO {$productId}</h2>";
    }

}
