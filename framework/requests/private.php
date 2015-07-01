<?php

/*
 * This handles requests within the back end of the website
 */

$modules->trigger('private_request');

if($modules->run_private_controller())
{
	$page->set_status(200);
	exit;
}

$page->set_status(404);
exit;
