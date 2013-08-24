<?php
class CustomDivisionTest extends TestCase
{
	public function testgetCustomDivisionInfo()
	{
		$url = 'http://api.sc2ranks.com/v2/custom-divisions/234';

		$this->expectPost($url)
			->andReturn($this->dataFile('getCdivInfo'));

		$result = $this->sc2r->getCdivInfo('234');

		$this->assertNotNull($result);
	}

	public function testgetCustomDivisionTeams()
	{
		$url = 'http://api.sc2ranks.com/v2/custom-divisions/teams/345';

		$this->expectPost($url)
			->andReturn($this->dataFile('getCdivTeams'));

		$result = $this->sc2r->getCdivTeams('345');

		$this->assertNotNull($result);
	}

	public function testgetCustomDivisionCharacters()
	{
		$url = 'http://api.sc2ranks.com/v2/custom-divisions/characters/456';

		$this->expectPost($url)
			->andReturn($this->dataFile('getCdivCharacters'));

		$result = $this->sc2r->getCdivCharacters('456');

		$this->assertNotNull($result);
	}

	public function testAddCustomDivisionPlayer()
	{
		$url = 'http://api.sc2ranks.com/v2/custom-divisions/manage/567';

		$player = $this->sc2r->createPlayer('eu', '12345');

		$data = array('characters' => array($player->toArray()));

		$this->expectPost($url, $data)
			->andReturn($this->dataFile('addCdivPlayer'));

		$result = $this->sc2r->addCdivPlayer('567', $player);

		$this->assertNotNull($result);
	}

	public function testRemoveCustomDivisionPlayer()
	{
		$url = 'http://api.sc2ranks.com/v2/custom-divisions/manage/678';

		$player = $this->sc2r->createPlayer('eu', '12345');

		$data = array('characters' => array($player->toArray()));

		$this->expectDelete($url, $data)
			->andReturn($this->dataFile('removeCdivPlayer'));

		$result = $this->sc2r->removeCdivPlayer('678', $player);

		$this->assertNotNull($result);
	}
}
