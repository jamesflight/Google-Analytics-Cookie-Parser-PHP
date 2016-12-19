<?php

use Jflight\GACookie\Parser;
use Jflight\GACookie\GACookie;
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

	public function testCanParseUtmaString()
	{
		$utma = GACookie::parseString('utma', '177910838.254655113.1474876189.1482142331.1482148790.58');
		$this->assertEquals('2016-09-26 07:49:49', $utma->time_of_first_visit->format('Y-m-d H:i:s'));
		$this->assertEquals('2016-12-19 10:12:11', $utma->time_of_last_visit->format('Y-m-d H:i:s'));
		$this->assertEquals('2016-12-19 11:59:50', $utma->time_of_current_visit->format('Y-m-d H:i:s'));
		$this->assertEquals(58, $utma->session_count);
	}

	public function testCanParseUtmzString()
	{
		$utmz = GACookie::parseString('utmz', '177910838.1481550491.52.15.utmcsr=newsletter|utmccn=campaign-2016|utmcmd=email');
		$this->assertEquals('newsletter', $utmz->source);
		$this->assertEquals('email', $utmz->medium);
		$this->assertEquals('campaign-2016', $utmz->campaign);
	}

	protected function getParser()
	{
		$this->utma = m::mock('Jflight\GACookie\Utma');
		$this->utmz = m::mock('Jflight\GACookie\Utmz');
		$parser = m::mock('Jflight\GACookie\Parser[getCookie]', array($this->utma, $this->utmz ));
		return $parser;
	}

}
