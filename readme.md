# SC2Ranks v2 API - PHP implementation
[![Build Status](https://travis-ci.org/anlutro/sc2ranks-v2.png?branch=master)](https://travis-ci.org/anlutro/sc2ranks-v2)

A simple object-oriented implementation of the second version of SC2Ranks API. The implementation parses JSON returned from the SC2Ranks API server and doesn't do anything to manipulate it. Check out the [API documentation](http://www.sc2ranks.com/api) for information on how the returned data is structured.

Package is still in development and can't be considered stable, but should be functional. Please report any problems via the Github issues page.

## Installation
Install as a [Composer](http://getcomposer.org) package: `composer require anlutro\sc2ranks-v2:dev-master`

## Usage
```php
$sc2r = new \anlutro\SC2Ranks\SC2Ranks('my_api_key');

$player = $sc2r->getPlayerFromProfileUrl('http://eu.battle.net/sc2/en/profile/180786/1/Raziel/');

try {
	$teams = $sc2r->getPlayerTeams($player);
	var_dump($teams);
} catch (\anlutro\SC2Ranks\SC2RanksException $e) {
	echo $e->getMessage();
}
```

## Functions
- `setDefault(array $array)` Pass an array of default values for league, region, bracket and expansion.
- `returnArray()` Return associative arrays instead of objects.
- `getRemainingCredits()` See how many remaining credits for API calls you have.
- `getsumCreditsSpent()` Get the sum of credits spent during the class's lifetime.
- `getCreditsSpentLast()` Get how many credits were spent on the last request.
- `getCreditsSpent()` Get an array of the calls ran and how many credits were spent on each.

- `getPlayerFromProfileUrl($url)` Get a Player object from a Battle.net or SC2Ranks profile URL.
- `createPlayer($region, $bnetId)` Get a Player object from region and Battle.net ID.
- `getPlayerCharacter(Player $player)` Get the character of a player.
- `getPlayerTeams(Player $player, $options = array())` Get the teams of a player.
- `searchCharacter($name, $options = array())` Search SC2Ranks for a name.
- `getBulkCharacters(array $players)` Get a large number of characters. Must be an array of Player objects.
- `getBulkTeams(array $players, array $options = array())` Get a large number of teams.
- `getClanInfo($region, $tag, $options = array())` Get info about a clan.
- `getClanCharacters($region, $tag, $options = array())` Get the characters of a clan's members.
- `getClanTeams($region, $tag, $options = array())` Get the teams of a clan's members.
- `getDivisionInfo($divId)` Get information on a division.
- `getDivisionTeams($divId, $limit = 10)` Get the teams of a division.
- `getCdivInfo($cdivId)` Get information on a custom division.
- `getCdivTeams($divId, $options = array())` Get the teams in a custom division.
- `getCdivCharacters($divId, $options = array())` Get the characters of a custom division.
- `addCdivPlayer($divId, Player $player)` Add a player to a custom division.
- `removeCdivPlayer($divId, Player $player)` Remove a player from a custom division.
- `addCdivPlayers` and `removeCdivPlayers` can be used in the same way, but you can pass an array of Player objects to add/remove more than one at the time.

# Contact
Open an issue on GitHub if you have any problems or suggestions.

If you have any questions or want to have a chat, look for anlutro @ chat.freenode.net.

# License
The contents of this repository is released under the [MIT license](http://opensource.org/licenses/MIT).