<?php

use Jflight\GACookie\Utmz;
use Mockery as m;

class UtmzTest extends \PHPUnit\Framework\TestCase {

	public function tearDown(): void
	{
		m::close();
	}

	public function testCanParseValidUtmzCookie()
	{
		$utmz = $this->getUtmz();
		$this->date->shouldReceive('createFromFormat')->with('U', 'timeStamp')->andReturn('DateObject');
		$result = $utmz->parse('dmhash.timeStamp.5.6');
		$this->assertEquals('DateObject', $result->timestamp);
		$this->assertSame(5, $result->session_count);
		$this->assertSame(6, $result->campaign_number);
	}

	public function testCanParseUtmzWithSource()
	{
		$utmz = $this->getUtmz();
		$this->date->shouldReceive('createFromFormat');
		$result = $utmz->parse('dmhash.timeStamp.sessionCount.campaignNo.utmcsr=google');
		$this->assertEquals('google',$result->source);
	}

	public function testCanParseUtmzWithMedium()
	{
		$utmz = $this->getUtmz();
		$this->date->shouldReceive('createFromFormat');
		$result = $utmz->parse('dmhash.timeStamp.sessionCount.campaignNo.utmcmd=cpc');
		$this->assertEquals('cpc',$result->medium);
	}

	public function testCanParseUtmzWithCampaign()
	{
		$utmz = $this->getUtmz();
		$this->date->shouldReceive('createFromFormat');
		$result = $utmz->parse('dmhash.timeStamp.sessionCount.campaignNo.utmccn=campaign');
		$this->assertEquals('campaign',$result->campaign);
	}

	public function testCanParseUtmzWithTerm()
	{
		$utmz = $this->getUtmz();
		$this->date->shouldReceive('createFromFormat');
		$result = $utmz->parse('dmhash.timeStamp.sessionCount.campaignNo.utmctr=term');
		$this->assertEquals('term',$result->term);
	}

	public function testCanParseUtmzWithContent()
	{
		$utmz = $this->getUtmz();
		$this->date->shouldReceive('createFromFormat');
		$result = $utmz->parse('dmhash.timeStamp.sessionCount.campaignNo.utmcct=content');
		$this->assertEquals('content',$result->content);
	}

	public function testCanSetMultipleExtraValues()
	{
		$utmz = $this->getUtmz();
		$this->date->shouldReceive('createFromFormat');
		$result = $utmz->parse('dmhash.timeStamp.sessionCount.campaignNo.utmcct=content|utmctr=term|utmccn=campaign');
		$this->assertEquals('content',$result->content);
		$this->assertEquals('term',$result->term);
		$this->assertEquals('campaign',$result->campaign);
	}

	public function testCanParseUtmzWithContentWithDots()
	{
		$utmz = $this->getUtmz();
		$this->date->shouldReceive('createFromFormat');
		$result = $utmz->parse('dmhash.timeStamp.sessionCount.campaignNo.utmcct=content.with.dots');
		$this->assertEquals('content.with.dots',$result->content);
	}

	public function getUtmz()
	{
		$this->date = m::mock('DateTime');
		return new Utmz($this->date);
	}
}