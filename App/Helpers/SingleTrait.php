<?php namespace App\Helpers;

trait SingleTrait {
	protected static $instance;

	public static function boot(...$data) 
	{
		if (!self::$instance) {
			// init 
			self::$instance = new self($data);
		}

		return self::$instance;
	} 
}