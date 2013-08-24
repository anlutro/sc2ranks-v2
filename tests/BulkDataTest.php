<?php
class BulkDataTest extends TestCase
{
	public function testGetBulkCharacters()
	{
		$player = $this->sc2r->createPlayer('eu', '12345');
		$players = array($player);
		$data = array('characters' => array($player->toArray()));

		$url = 'http://api.sc2ranks.com/v2/bulk/characters';

		$this->expectPost($url, $data)
			->andReturn($this->dataFile('getBulkCharacters'));

		$result = $this->sc2r->getBulkCharacters($players);

		$this->assertNotNull($result);
	}

	public function testGetBulkTeams()
	{
		$player = $this->sc2r->createPlayer('eu', '12345');
		$players = array($player);
		$data = array('characters' => array($player->toArray()));

		$url = 'http://api.sc2ranks.com/v2/bulk/teams';

		$this->expectPost($url, $data)
			->andReturn($this->dataFile('getBulkTeams'));

		$result = $this->sc2r->getBulkTeams($players);

		$this->assertNotNull($result);
	}
}
