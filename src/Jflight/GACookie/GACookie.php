<?php namespace Jflight\GACookie;

use Illuminate\Container\Container;

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
		$parser = $c->make('Jflight\GACookie\Parser');
		return $parser->parse($cookieName);
	}
}