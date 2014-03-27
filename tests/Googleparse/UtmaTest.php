<?php

use Jflight\Googleparse\Utma;
use Mockery as m;

class UtmaTest extends PHPUnit_Framework_TestCase {

	public function testCanParseValidUtmaCookie()
	{
		$utma = $this->getUtma();
		$this->date->shouldReceive('setTimeStamp')->with('initialTime')->andReturn('FirstDateObject');
		$this->date->shouldReceive('setTimeStamp')->with('lastTime')->andReturn('LastDateObject');
		$this->date->shouldReceive('setTimeStamp')->with('currentTime')->andReturn('CurrentDateObject');
		$result = $utma->parse('dmhash.randid.initialTime.lastTime.currentTime.sessionCount');
		$this->assertEquals('FirstDateObject', $result->time_of_first_visit);
		$this->assertEquals('LastDateObject', $result->time_of_last_visit);
		$this->assertEquals('CurrentDateObject', $result->time_of_current_visit);
		$this->assertEquals('sessionCount', $result->session_count);
	}

	protected function getUtma()
	{
		$this->date = m::mock('DateTimeImmutable');
		return new Utma($this->date);
	}
}
