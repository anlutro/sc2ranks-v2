<?php
class CharacterCreationTest extends TestCase
{
	public function testBattleNetWithHttp()
	{
		$player = $this->sc2r->getPlayerFromProfileUrl('http://eu.battle.net/sc2/en/profile/123456/1/Test/');
		$this->assertValidPlayer($player, array('eu', '123456'));
	}

	public function testBattleNetWithoutHttp()
	{
		$player = $this->sc2r->getPlayerFromProfileUrl('eu.battle.net/sc2/en/profile/123456/1/Test');
		$this->assertValidPlayer($player, array('eu', '123456'));
	}

	public function testSc2RanksWithHttp()
	{
		$player = $this->sc2r->getPlayerFromProfileUrl('http://www.sc2ranks.com/character/eu/123456/Test');
		$this->assertValidPlayer($player, array('eu', '123456'));
	}

	public function testSc2RanksWithoutHttp()
	{
		$player = $this->sc2r->getPlayerFromProfileUrl('www.sc2ranks.com/character/eu/123456/Test');
		$this->assertValidPlayer($player, array('eu', '123456'));
	}

	protected function assertValidPlayer($player, $expected = null)
	{
		if ($expected instanceof anlutro\SC2Ranks\Player) {
			$this->assertEquals($player, $expected);
		} elseif (is_array($expected)) {
			$this->assertEquals($player->region, $expected[0]);
			$this->assertEquals($player->bnetId, $expected[1]);
		}

		$this->assertTrue(in_array(
			$player->region,
			array('eu', 'am', 'kr', 'sea', 'cn')
		));

		$this->assertTrue(is_numeric($player->bnetId));
	}
}
