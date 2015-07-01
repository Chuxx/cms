<?php

/*
 * This handle requests for pages of the front end website
 */

$modules->trigger('public_request');

if($modules->run_public_controller()) exit;

if($modules->trigger('unhandled_public_request')) exit;

