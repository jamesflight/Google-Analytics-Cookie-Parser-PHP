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
	 * @return Jflight\GACookie\ParseInterface
	 */
	public function parse($cookieName)
	{
		if (property_exists($this, $cookieName))
		{
			return $this->$cookieName->parse($this->getCookie('__' . $cookieName));
		} else
		{
			throw new \InvalidArgumentException("'" . $cookieName . "' is not a supported google cookie type.");
		}
		
	}

	/**
	 * Wrapper for $_COOKIE for testing purposes
	 * @param  string $name
	 * @return string
	 */
	public function getCookie($name)
	{
		return $_COOKIE[$name];
	}
}