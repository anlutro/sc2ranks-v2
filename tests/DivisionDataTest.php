<?php
class DivisionDataTest extends TestCase
{
	public function testGetDivisionList()
	{
		$url = 'http://api.sc2ranks.com/v2/divisions';
		
		$this->expectPost($url)
			->andReturn($this->dataFile('getDivisionList'));

		$result = $this->sc2r->getDivisionList();

		$this->assertNotNull($result);
	}

	public function testGetDivisionInfo()
	{
		$url = 'http://api.sc2ranks.com/v2/divisions/123';
		
		$this->expectPost($url)
			->andReturn($this->dataFile('getDivisionInfo'));
		
		$result = $this->sc2r->getDivisionInfo('123');

		$this->assertNotNull($result);
	}

	public function testGetDivisionTeams()
	{
		$url = 'http://api.sc2ranks.com/v2/divisions/teams/123';
		
		$this->expectPost($url)
			->andReturn($this->dataFile('getDivisionTeams'));

		$result = $this->sc2r->getDivisionTeams('123');

		$this->assertNotNull($result);
	}
}
