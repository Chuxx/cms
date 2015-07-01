<?php

class modules
{
	
	private $modules = array();
	
	
	
	public function __construct()
	{
		$this->prepare_modules();
	}
	
	
	
	private function load_module_config($module_name)
	{
		return json_decode(file_get_contents(dirname(__FILE__) . '/../../modules/' . $module_name . '/config.json'), true);
	}
	
	
	
	private function save_module_config($module_name)
	{
		file_put_contents(dirname(__FILE__) . '/../../modules/' . $module_name . '/config.json', json_encode($this->modules[$module_name]));
	}
	
	
	
	public function prepare_modules()
	{
		foreach(scandir(dirname(__FILE__) . '/../../modules') as $id => $module)
		{
			if($module == '.' || $module == '..') continue;
			$this->modules[$module] = $this->load_module_config($module);
		}
	}
	
	
	
	public function enable($module_name)
	{
		if(!isset($this->modules[$module_name])) return false;
		$this->modules[$module_name]['enabled'] = true;
		$this->save_module_config($module_name);
	}
	
	
	
	public function disable($module_name)
	{
		if(!isset($this->modules[$module_name])) return false;
		$this->modules[$module_name]['enabled'] = false;
		$this->save_module_config($module_name);
	}
	
	
	
	public function is_module_enabled($module_name)
	{
		if(!isset($this->modules[$module_name])) return false;
		return $this->modules[$module_name]['enabled'];
	}
	
	
	
	public function get_module_version($module_name)
	{
		if(!isset($this->modules[$module_name])) return null;
		return $this->modules[$module_name]['version'];
	}
	
	
	
	public function get_modules_installed()
	{
		return array_keys($this->modules);
	}
	
	
	
	public function get_modules_enabled()
	{
		$enabled = array();
		foreach($this->modules as $name => $config) if($config['enabled']) $enabled[] = $name;
		return $enabled;
	}
}