<?php

/*
 * This class is accessed statically to get information about the current request
 */

abstract class request
{
	private static $url = null;
	
	public static function ip()
	{
		return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
	}
	
	public static function url($part, $default_value = null)
	{
		if(is_null(self::$url))
		{
			$url = self::get('url');
			if($url == 'index.php') $url = null;
			self::$url = explode('/', rtrim($url, '/'));
			if(!isset(self::$url[0]) || empty(self::$url[0])) self::$url = null;
		}
		
		if(is_int($part) && !is_null(self::$url))
		{
			$part--;
			if($part == -1) return implode('/', self::$url);
			if(isset(self::$url[$part])) return self::$url[$part];
		}
		return $default_value;
	}
	
	public static function get($key, $default_value = null)
	{
		return isset($_GET[$key]) ? $_GET[$key] : $default_value;
	}
	
	public static function post($key, $default_value = null)
	{
		return isset($_POST[$key]) ? $_POST[$key] : $default_value;
	}
	
	public static function files($key, $default_value = null)
	{
		if(!isset($_FILES[$key])) return $default_value;
	
		$file = $_FILES[$key];
		if(is_array($file['size']))
		{
			$files = array();
			foreach($file['size'] as $key => $data)
			{
				$files[] = array(
						'size' => $file['size'][$key],
						'error' => $file['error'][$key],
						'tmp_name' => $file['tmp_name'][$key],
						'name' => $file['name'][$key],
						'type' => $file['type'][$key]
				);
			}
			return $files;
		}
		else
		{
			return $file;
		}
	}
	
	public static function sid()
	{
		return session_id();
	}
	
	public static function session($key, $default_value = null)
	{
		return isset($_SESSION[$key]) ? $_SESSION[$key] : $default_value;
	}
	
	public static function cookie($key, $default_value = null)
	{
		return isset($_COOKIE[$key]) ? $_COOKIE[$key] : $default_value;
	}
}