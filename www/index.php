<?php

/*
 * Every single request will come through this file first
 * 
 * TODO: Determine which type of request this is and what is being requested
 * TODO: Route the request to the appropriate request handler
 */

require_once dirname(__FILE__) . '/../framework/initialise.php';

$extension = explode('.', request::url(0));
$extension = end($extension);

switch($extension)
{
	case 'css': $handler = 'css'; break;
	case 'js': $handler = 'javascript'; break;
	case 'jpg': $handler = 'image'; break;
	case 'png': $handler = 'image'; break;
	case 'gif': $handler = 'image'; break;
	case 'jpeg': $handler = 'image'; break;
	case request::url(0):
		switch(request::url(1))
		{
			case 'api': $handler = 'remote'; break;
			case 'cms': $handler = 'private'; break;
			default: $handler = 'public'; break;
		}
	break;
	default:
		echo "OTHER!";
		exit;
	break;
}

unset($extension);

require_once dirname(__FILE__) . '/../framework/requests/' . $handler . '.php';
