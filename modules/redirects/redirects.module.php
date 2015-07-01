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
		if(is_null($this->connection) || !($query = $this->connection->query("SELECT * FROM `redirects`"))) return false;
		$redirects = $query->fetchAll(PDO::FETCH_ASSOC);
		foreach($redirects as $r)
		{
			if(preg_match('|^' . $r['from'] . '$|', request::url(0)) === 1)
			{
				$url = preg_replace('|^' . $r['from'] . '$|', $r['to'], request::url(0));
				header('Location:/', true, 301);
				return true;
			}
		}
		return false;
	}
}