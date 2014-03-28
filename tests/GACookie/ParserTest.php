<?php

use Jflight\GACookie\Parser;
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

	public function testReturnsFalseIfCookieDoesntExist()
	{
		$parser = $this->getParser();
		$parser->shouldReceive('getCookie')->once()->andReturn(false);
		$result = $parser->parse('utmz');
		$this->assertSame(false,$result);
	}
	

	protected function getParser()
	{
		$this->utma = m::mock('Jflight\GACookie\Utma');
		$this->utmz = m::mock('Jflight\GACookie\Utmz');
		$parser = m::mock('Jflight\GACookie\Parser[getCookie]', array($this->utma, $this->utmz ));
		return $parser;
	}

}