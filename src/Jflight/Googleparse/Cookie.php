<?php namespace Jflight\Googleparse;

abstract class Cookie implements \ArrayAccess
{
	public function offsetExists($offset)
	{
		return property_exists($this, $offset);
	}

	public function offsetGet($offset)
	{
		return $this->$offset;
	}

	public function offsetSet($offset, $value)
	{
		$this->$offset = $value;
	}

	public function offsetUnset($offset)
	{
		$this->$offset = null;
	}

}

