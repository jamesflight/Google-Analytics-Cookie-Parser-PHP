<?php

use Jflight\Googleparse\Parser;
use Mockery as m;

class ParserTest extends PHPUnit_Framework_TestCase {

	public function tearDown()
	{
		m::close();
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testExceptionIfInvalidArgumentProvided()
	{
		$parser = $this->getParser();
		$parser->parse('invalid');
	}

	public function testCanParseUtmaCookie()
	{
		$parser = $this->getParser();
		$parser->shouldReceive('getCookie')->once()->with('__utma')->andReturn('cookie_content');
		$this->utma->shouldReceive('parse')->with('cookie_content')->andReturn('cookie_object');
		$result = $parser->parse('utma');
		$this->assertEquals('cookie_object', $result);
	}

	public function testCanParseUtmzCookie()
	{
		$parser = $this->getParser();
		$parser->shouldReceive('getCookie')->once()->with('__utmz')->andReturn('cookie_content');
		$this->utmz->shouldReceive('parse')->with('cookie_content')->andReturn('cookie_object');
		$result = $parser->parse('utmz');
		$this->assertEquals('cookie_object', $result);
	}
	

	protected function getParser()
	{
		$this->utma = m::mock('Jflight\Googleparse\Utma');
		$this->utmz = m::mock('Jflight\Googleparse\Utmz');
		$parser = m::mock('Jflight\Googleparse\Parser[getCookie]', array($this->utma, $this->utmz));
		return $parser;
	}

}