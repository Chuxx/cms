<?php

/*
 * This class is accessed statically to get information about the current request
 */

abstract class request
{
	public static function ip()
	{
		return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
	}
	
	public static function time()
	{
		return self::$time;
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