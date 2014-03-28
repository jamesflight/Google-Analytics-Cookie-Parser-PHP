<?php
use Jflight\Googleparse\Cookie;
use Mockery as m;

class CookieTest extends PHPUnit_Framework_TestCase {

	public function tearDown()
	{
		m::close();
	}
	
	public function testCanAccessAsArray()
	{
		$cookie = $this->getCookieStub();
		$cookie['property'];
		$this->assertEquals('Foo', $cookie['property']);
	}

	public function testCanSetPropertyAsArray()
	{
		$cookie = $this->getCookieStub();
		$cookie['property'] = 'Bar';
		$this->assertEquals('Bar', $cookie->property);
	}

	public function testUnsetArrayEmptiesProperty()
	{
		$cookie = $this->getCookieStub();
		unset($cookie['property']);
		$this->assertEquals(null, $cookie['property']);
	}

	protected function getCookieStub()
	{
		return new CookieTestStub;
	}
}

class CookieTestStub extends Cookie
{
	public $property = 'Foo';
}