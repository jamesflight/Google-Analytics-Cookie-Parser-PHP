<?php

use Jflight\Googleparse\Parser;
use Mockery as m;

class ParserTest extends PHPUnit_Framework_TestCase {

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
	

	protected function getParser()
	{
		$this->utma = m::mock('Jflight\Googleparse\Utma');
		$parser = m::mock('Jflight\Googleparse\Parser[getCookie]', array($this->utma));
		return $parser;
	}

}