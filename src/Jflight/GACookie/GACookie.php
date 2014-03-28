<?php

use Illuminate\Container\Container;
use Jflight\GACookie\Parser;

class GACookie
{
	/**
	 * Static shortcut to Parser 'parse' method
	 * @param  string $cookieName
	 * @return Jflight\GACookie\Cookie
	 */
	public static function parse($cookieName)
	{
		$c = new Container;
		$parser = $c->make('Parser');
		return $parser->parse($cookieName);
	}
}