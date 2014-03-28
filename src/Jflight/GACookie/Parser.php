<?php namespace Jflight\GACookie;

use Jflight\GACookie\Cookie;
use Jflight\GACookie\Resolver;
use Jflight\GACookie\ParseInterface;

class Parser
{
	/**
	 * Constructor
	 * @param Utma $utma
	 */
	public function __construct(Utma $utma, Utmz $utmz)
	{
		$this->utma = $utma;
		$this->utmz = $utmz;
	}

	/**
	 * Checks valid cookie type and passes the cookie string down to correct cookie object
	 * @param  string $cookieName
	 * @return Jflight\GACookie\ParseInterface|bool
	 */
	public function parse($cookieName)
	{
		if (property_exists($this, $cookieName))
		{
			$cookie = $this->getCookie('__' . $cookieName);

			if ($cookie)
			{
				return $this->$cookieName->parse($cookie);
			} else
			{
				return false;
			}
			
		} else
		{
			throw new \InvalidArgumentException("'" . $cookieName . "' is not a supported google cookie type.");
		}
		
	}

	/**
	 * Wrapper for $_COOKIE for testing purposes. This funciton has to be untested.
	 * @param  string $name
	 * @return string|bool
	 */
	public function getCookie($name)
	{
		if (isset($_COOKIE[$name]))
		{
			return $_COOKIE[$name];
		} else
		{
			return false;
		}
	}
}