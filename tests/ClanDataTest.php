<?php
class ClanDataTest extends TestCase
{
	public function testGetClanInfo()
	{
		$url = 'http://api.sc2ranks.com/v2/clans/eu/tag';

		$this->expectPost($url)
			->andReturn($this->dataFile('getClanInfo'));

		$result = $this->sc2r->getClanInfo('eu', 'tag');

		$this->assertNotNull($result);
	}

	public function testGetClanCharacters()
	{
		$url = 'http://api.sc2ranks.com/v2/clans/characters/eu/tag';

		$this->expectPost($url)
			->andReturn($this->dataFile('getClanCharacters'));

		$result = $this->sc2r->getClanCharacters('eu', 'tag');

		$this->assertNotNull($result);
	}

	public function testGetClanTeams()
	{
		$url = 'http://api.sc2ranks.com/v2/clans/teams/eu/tag';

		$this->expectPost($url)
			->andReturn($this->dataFile('getClanTeams'));

		$result = $this->sc2r->getClanTeams('eu', 'tag');

		$this->assertNotNull($result);
	}
}
