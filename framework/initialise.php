<?php

/*
 * Initialise the application environment how we want it to be for every request
 */

require_once '../configuration/settings.class.php';

if(settings::DEBUGGING)
{
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
}
else
{
	ini_set('display_errors', 0);
}

require_once 'utilities/request.class.php';
require_once 'utilities/page.class.php';
require_once 'utilities/connection.class.php';
require_once 'utilities/module.class.php';
require_once 'handlers/modules.class.php';

$page = new page();
$connection = new connection();
$modules = new modules($connection, $page);
