<?php namespace Jflight\Googleparse;

use Jflight\Googleparse\ParseInterface;

class Utmz extends Cookie
{
	/**
	 * Timestamp
	 * @var string
	 */
	public $timestamp;

	/**
	 * Session count
	 * @var string
	 */
	public $session_count;

	/**
	 * Campaign number
	 * @var string
	 */
	public $campaign_number;

	/**
	 * Source
	 * @var string
	 */
	public $source;

	/**
	 * Medium
	 * @var string
	 */
	public $medium;

	/**
	 * Campaign
	 * @var string
	 */
	public $campaign;

	/**
	 * Term
	 * @var string
	 */
	public $term;

	/**
	 * Content
	 * @var string
	 */
	public $content;

	/**
	 * Maps the string values in the cookie to the properties of the Utmz object
	 * @var array
	 */
	protected $keyMappings = array(
						'utmcsr' => 'source',
						'utmcmd' => 'medium',
						'utmccn' => 'campaign',
						'utmctr' => 'term',
						'utmcct' => 'content'
						);

	/**
	 * Constructor
	 * @param DateTimeImmutable $date
	 */
	public function __construct(\DateTimeImmutable $date)
	{
		$this->date = $date;
	}

	/**
	 * Parse cookie string and assign properties to this
	 * @param  string $cookie The string from inside the cookie
	 * @return static
	 */
	public function parse($cookie)
	{
		$cookieBits = explode('.', $cookie);
		$this->timestamp = $this->date->setTimeStamp($cookieBits[1]);
		$this->session_count = $cookieBits[2];
		$this->campaign_number = $cookieBits[3];
		$array = $this->paramsToArray($cookieBits);
		$this->setExtras($array);
		return $this;
	}

	/**
	 * Logic for setting the extras values from the cookie as object properties
	 * @param array $array
	 */
	protected function setExtras($array)
	{
		if (is_array($array))
		{
			foreach ($array as $key => $item)
			{
				if (array_key_exists($key, $this->keyMappings))
				{
					$property = $this->keyMappings[$key];
					$this->$property = $item;
				}
			}
		}
	}

	/**
	 * Logic for splitting the extra properties from string to array
	 * @param  string $cookie
	 * @return array
	 */
	protected function paramsToArray($cookie)
	{
		if (isset($cookie[4]))
		{

			$pairs = explode('|', $cookie[4]);

			foreach ($pairs as $pair)
			{
				$item = explode('=', $pair);

				$return[$item[0]] = $item[1];
			}

			return $return;
		} 
	}
}