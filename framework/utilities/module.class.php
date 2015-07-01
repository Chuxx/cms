<?php

abstract class module
{
	protected $modules;
	protected $connection;
	protected $page;
	
	public function __construct($modules, $connection, $page)
	{
		$this->modules = $modules;
		$this->connection = $connection;
		$this->page = $page;
	}
}