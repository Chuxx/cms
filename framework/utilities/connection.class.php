<?php

class connection extends PDO
{
	public function __construct()
	{
		parent::__construct('mysql:host=' . settings::DB_HOST . ';dbname=' . settings::DB_NAME, settings::DB_USER, settings::DB_PASS);
		parent::setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		if(settings::DEBUGGING)
		{
			parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		}
		else
		{
			parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERR_NONE);
		}
	}
}