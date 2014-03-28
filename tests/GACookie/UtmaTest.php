<?php

use Jflight\GACookie\Utma;
use Mockery as m;

class UtmaTest extends PHPUnit_Framework_TestCase {

	public function tearDown()
	{
		m::close();
	}

	public function testCanParseValidUtmaCookie()
	{
		$utma = $this->getUtma();
		$this->date->shouldReceive('createFromFormat')->with('U', 'initialTime')->andReturn('FirstDateObject');
		$this->date->shouldReceive('createFromFormat')->with('U', 'lastTime')->andReturn('LastDateObject');
		$this->date->shouldReceive('createFromFormat')->with('U', 'currentTime')->andReturn('CurrentDateObject');
		$result = $utma->parse('dmhash.randid.initialTime.lastTime.currentTime.5');
		$this->assertEquals('FirstDateObject', $result->time_of_first_visit);
		$this->assertEquals('LastDateObject', $result->time_of_last_visit);
		$this->assertEquals('CurrentDateObject', $result->time_of_current_visit);
		$this->assertSame(5, $result->session_count);
	}

	protected function getUtma()
	{
		$this->date = m::mock('DateTime');
		return new Utma($this->date);
	}
}
