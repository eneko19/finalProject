<?php

require_once ('db/db.php');
require_once ('db/dbObject.php');
require_once("controllers/incidence_controller.php");


$controller = new incidence_controller();

$controller->viewHome();

