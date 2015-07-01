<?php

class pages_module extends module
{
	public function unhandled_public_request()
	{
		$this->page->set_title('Testing');
		$this->page->set_status(200);
		
		if(is_null($this->connection)) return false;
		$q = $this->connection->prepare("SELECT * FROM `pages` WHERE `url` = :url LIMIT 1");
		$q->bindValue(':url', request::url(0), PDO::PARAM_STR);
		if(!$q->execute() || $q->rowCount() == 0) return false;
		$page = $q->fetch(PDO::FETCH_ASSOC);
		return true;
	}
}