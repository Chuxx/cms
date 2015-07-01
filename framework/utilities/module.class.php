<?php

abstract class module
{
	protected $connection;
	protected $page;
	
	public function __construct($connection, $page)
	{
		$this->connection = $connection;
		$this->page = $page;
	}
}