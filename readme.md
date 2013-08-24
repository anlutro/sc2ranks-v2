# SC2Ranks v2 API - PHP implementation

## Usage
```php
$sc2r = new \anlutro\SC2Ranks\SC2Ranks('my_api_key');
$player = $sc2r->getPlayerFromProfileUrl('http://eu.battle.net/sc2/en/profile/180786/1/Raziel/');
try {
	$teams = $sc2r->getPlayerTeams($player);
	var_dump($teams);
} catch (SC2RanksException $e) {
	echo $e->getMessage();
}
```

## Functions
`setDefault(array $array)` Pass an array of default values for league, region, bracket and expansion.
`returnArray()` Return associative arrays instead of objects.
`getPlayerFromProfileUrl($url)` Get a Player object from a Battle.net or SC2Ranks profile URL.
`createPlayer($region, $bnetId)` Get a Player object from region and Battle.net ID.
`getPlayerCharacter(Player $player)` Get the character of a player.
`getPlayerTeams(Player $player, $options = array())` Get the teams of a player.
`searchCharacter($name, $options = array())` Search SC2Ranks for a name.
`getBulkCharacters(array $players)` Get a large number of characters. Must be an array of Player objects.
`getBulkTeams(array $players, array $options = array())` Get a large number of teams.
`getClanInfo($region, $tag, $options = array())` Get info about a clan.
`getClanCharacters($region, $tag, $options = array())` Get the characters of a clan's members.
`getClanTeams($region, $tag, $options = array())` Get the teams of a clan's members.
`getDivisionInfo($divId)` Get information on a division.
`getDivisionTeams($divId, $limit = 10)` Get the teams of a division.
`getCdivInfo($cdivId)` Get information on a custom division.
`getCdivTeams($divId, $options = array())` Get the teams in a custom division.
`getCdivCharacters($divId, $options = array())` Get the characters of a custom division.
`addCdivPlayer($divId, Player $player)` Add a player to a custom division.
`removeCdivPlayer($divId, Player $player)` Remove a player from a custom division.
`getRemainingCredits()` See how many remaining credits for API calls you have.