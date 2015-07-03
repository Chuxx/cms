<?php

class modules
{
	
	private $modules = array();
	private $loaded_modules = array();
	
	
	
	public function __construct($connection, $page)
	{
		$this->prepare_modules($connection, $page);
	}
	
	
	
	private function load_module_config($module_name)
	{
		return json_decode(file_get_contents(dirname(__FILE__) . '/../../modules/' . $module_name . '/config.json'), true);
	}
	
	
	
	private function save_module_config($module_name)
	{
		file_put_contents(dirname(__FILE__) . '/../../modules/' . $module_name . '/config.json', json_encode($this->modules[$module_name]));
	}
	
	
	
	public function prepare_modules($connection, $page)
	{
		foreach(scandir(dirname(__FILE__) . '/../../modules') as $id => $module)
		{
			if($module == '.' || $module == '..') continue;
			$this->modules[$module] = $this->load_module_config($module);
		}
		
		foreach($this->get_modules_enabled() as $module_name)
		{
			require_once dirname(__FILE__) . '/../../modules/' . $module_name . '/' . $module_name . '.module.php';
			$class = $module_name . '_module';
			$this->loaded_modules[$module_name] = new $class($this, $connection, $page);
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
	
	
	public function trigger()
	{
		$args = func_get_args();
		if(count($args) == 0) return false;
		$event = array_shift($args);
		
		foreach($this->loaded_modules as $name => $module)
		{
			if(method_exists($module, $event)) return call_user_func_array(array($module, $event), $args);
		}
		return false;
	}
	
	
	public function run_public_controller()
	{
		foreach($this->get_modules_enabled() as $module_name)
		{
			if(file_exists(dirname(__FILE__) . '/../../modules/' . $module_name . '/public/controllers/' . request::url(1) . '.php'))
			{
				$this->modules->trigger('handled_public_request');
				require_once dirname(__FILE__) . '/../../modules/' . $module_name . '/public/controllers/' . request::url(1) . '.php';
				return true;
			}
		}
		return false;
	}
	
	
	public function run_private_controller()
	{
		foreach($this->get_modules_enabled() as $module_name)
		{
			if(file_exists(dirname(__FILE__) . '/../../modules/' . $module_name . '/private/controllers/' . request::url(2) . '.php'))
			{
				$this->modules->trigger('handled_private_request');
				require_once dirname(__FILE__) . '/../../modules/' . $module_name . '/private/controllers/' . request::url(2) . '.php';
				return true;
			}
		}
		return false;
	}
}