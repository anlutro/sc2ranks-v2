<?php
class CharacterDataTest extends TestCase
{
	public function testGetCharacter()
	{
		$player = $this->sc2r->createPlayer('eu', '12345');
		$url = 'http://api.sc2ranks.com/v2/characters/eu/12345';

		$this->expectGet($url)
			->andReturn($this->dataFile('getPlayerCharacter'));

		$result = $this->sc2r->getPlayerCharacter($player);

		$this->assertNotNull($result);
	}

	public function testGetPlayerTeams()
	{
		$player = $this->sc2r->createPlayer('eu', '12345');
		$url = 'http://api.sc2ranks.com/v2/characters/teams/eu/12345';

		$this->expectPost($url)
			->andReturn($this->dataFile('getPlayerTeams'));

		$result = $this->sc2r->getPlayerTeams($player);

		$this->assertNotNull($result);
	}

	public function testSearchCharacters()
	{
		$url = 'http://api.sc2ranks.com/v2/characters/search';
		
		$this->expectPost($url, array('name' => 'test'))
			->andReturn($this->dataFile('searchCharacter'));

		$result = $this->sc2r->searchCharacter('test');

		$this->assertNotNull($result);
	}
}
