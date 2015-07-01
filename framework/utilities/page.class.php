<?php

class page
{
	private $status = 404;
	private $title = null;
	
	public function set_title($title)
	{
		$this->title = $title;
	}
	
	public function set_status($code)
	{
		$this->status = $code;
	}
	
	public function __destruct()
	{
		if($this->status == 404)
		{
			header('HTTP/1.0 404 Not Found');
			echo "404 Not Found!";
			return;
		}
		
		echo $this->title;
	}
}