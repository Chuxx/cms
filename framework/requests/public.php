<?php

/*
 * This handle requests for pages of the front end website
 */

$modules->trigger('public_request');

if($modules->run_public_controller())
{
	$page->set_status(200);
	exit;
}

if($modules->trigger('unhandled_public_request'))
{
	$page->set_status(200);
	exit;
}

$page->set_status(404);
exit;
