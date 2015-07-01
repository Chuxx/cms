<?php

class redirects_module extends module
{
	/**
	 * When a public page is requested, check if the url is being redirected
	 * 
	 * @return boolean
	 */
	public function public_request()
	{
		if(!($query = $this->connection->query("SELECT * FROM `redirects`"))) return false;
		$redirects = $query->fetchAll(PDO::FETCH_ASSOC);
		foreach($redirects as $r)
		{
			$from = str_replace('*', '(.*)', $r['from_url']);
			if(preg_match('|^' . $from . '$|', request::url(0)) === 1)
			{
				$this->modules->trigger('http_status_301');
				$url = preg_replace('|^' . $from . '$|', $r['to_url'], request::url(0));
				$this->page->set_status(301);
				header('Location:/' . $url, true, 301);
				exit;
			}
		}
		return false;
	}
}