<?php

/*
 * Initialise the application environment how we want it to be for every request
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'handlers/modules.class.php';
require_once 'utilities/request.class.php';

$modules = new modules();
