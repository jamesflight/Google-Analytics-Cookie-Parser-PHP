<?php namespace Jflight\Googleparse;

use Jflight\Googleparse\Cookie;
use Jflight\Googleparse\Resolver;
use Jflight\Googleparse\ParseInterface;

class Parser
{
	/**
	 * Constructor
	 * @param Utma $utma
	 */
	public function __construct(Utma $utma)
	{
		$this->utma = $utma;
	}

	/**
	 * Checks valid cookie type and passes the cookie string down to correct cookie object
	 * @param  string $cookieName
	 * @return Jflight\Googleparse\ParseInterface
	 */
	public function parse($cookieName)
	{
		if (property_exists($this, $cookieName))
		{
			return $this->$cookieName->parse($this->getCookie('__' . $cookieName));
		} else
		{
			throw new \InvalidArgumentException("'" . $cookieName . "' is not a valid google cookie type.");
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