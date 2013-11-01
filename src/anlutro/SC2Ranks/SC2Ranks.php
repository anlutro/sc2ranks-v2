<?php
/**
 * SC2Ranks v2 API - PHP library
 * 
 * @author  Andreas Lutro <anlutro@gmail.com>
 * @license http://opensource.org/licenses/MIT
 * @package anlutro/sc2ranks-v2
 */

namespace anlutro\SC2Ranks;

use anlutro\cURL\cURL;

/**
 * The main class for interacting with SC2Ranks.
 */
class SC2Ranks
{
	protected $allowed = array(
		'leagues' => array('all', 'grandmaster', 'master', 'diamond',
			'platinum', 'gold', 'silver', 'bronze'),
		'regions' => array('global', 'us', 'tw', 'kr', 'la', 'ru'),
		'rank_regions' => array('global', 'eu', 'sea', 'cn', 'fea', 'am'),
		'expansions' => array('hots', 'wol'),
		'races' => array('zerg', 'protoss', 'terran', 'random'),
		'brackets' => array('1v1', '2v2t', '3v3t', '4v4t', '2v2r', '3v3r', '4v4r'),
	);

	protected $default = array(
		'league'    => 'all',
		'region'    => 'global',
		'expansion' => 'hots',
		'bracket'   => '1v1',
	);

	protected $apiKey;

	protected $curl;

	protected $returnArray = false;

	protected $creditsSpent = array();

	protected $sumCreditsSpent = 0;

	public function __construct($apiKey, $curl = null)
	{
		$this->apiKey = $apiKey;
		$this->curl = $curl ?: new cURL;
	}

	/**
	 * Set the default options.
	 *
	 * @param array $options
	 */
	public function setDefault(array $options)
	{
		$this->default = array_merge($this->default, $options);
	}

	/**
	 * Whether the class should return arrays instead of StdClass when fetching
	 * results from the API.
	 *
	 * @param  boolean $value
	 * 
	 * @return void
	 */
	public function returnArray($value = true)
	{
		$this->returnArray = $value;
	}

	/**
	 * Get the underlying cURL instance.
	 *
	 * @return \anlutro\cURL\cURL
	 */
	public function getCurl()
	{
		return $this->curl;
	}

	/**
	 * Get info on a player from an URL.
	 *
	 * @param  string $profileUrl
	 *
	 * @return Player
	 */
	public function getPlayerFromProfileUrl($profileUrl)
	{
		$player = new Player;
		$player->parseUrl($profileUrl);
		return $player;
	}

	/**
	 * Create a player instance when you know the region and bnet ID.
	 *
	 * @param  string $region
	 * @param  string $bnetId
	 *
	 * @return Player
	 */
	public function createPlayer($region, $bnetId)
	{
		return new Player($region, $bnetId);
	}

	public function getPlayerCharacter(Player $player)
	{
		$url = 'http://api.sc2ranks.com/v2/characters/'.
			$player->region.'/'.
			$player->bnetId;
		
		return $this->get($url);
	}

	public function getPlayerTeams(Player $player, $options = array())
	{
		$default = array(
			'expansion' => $this->default['expansion'],
			'bracket' => $this->default['bracket'],
			'league' => $this->default['league'],
		);

		$data = array_merge($default, $options);

		$url = 'http://api.sc2ranks.com/v2/characters/teams/'.
			$player->region.'/'.$player->bnetId;

		return $this->post($url, $data);
	}

	public function searchCharacter($name, $options = array())
	{
		$default = array(
			'rank_region' => $this->default['region'],
			'expansion' => $this->default['expansion'],
			'bracket' => $this->default['bracket'],
			'league' => $this->default['league']
		);

		$data = array_merge($default, $options);

		$data['name'] = $name;

		$url = 'http://api.sc2ranks.com/v2/characters/search';

		return $this->post($url, $data);
	}

	public function getBulkCharacters(array $players)
	{
		$data = array('characters' => array());

		foreach ($players as $player) {
			$data['characters'][] = $player->toArray();
		}

		$url = 'http://api.sc2ranks.com/v2/bulk/characters';

		return $this->post($url, $data);
	}

	public function getBulkTeams(array $players, array $options = array())
	{
		$default = array(
			'rank_region' => $this->default['region'],
			'expansion' => $this->default['expansion'],
			'bracket' => $this->default['bracket'],
			'league' => $this->default['league']
		);

		$data = array_merge($default, $options);

		$data['characters'] = array();

		foreach ($players as $player) {
			$data['characters'][] = $player->toArray();
		}

		$url = 'http://api.sc2ranks.com/v2/bulk/teams';

		return $this->post($url, $data);
	}

	public function getClanInfo($region, $tag, $options = array())
	{
		$default = array('bracket' => $this->default['bracket']);

		$url = 'http://api.sc2ranks.com/v2/clans/'.
			$region.'/'.$tag;

		$data = array_merge($default, $options);

		return $this->post($url, $data);
	}

	public function getClanCharacters($region, $tag, $options = array())
	{
		$default = array(
			'bracket' => $this->default['bracket'],
			'limit' => 50,
		);

		$data = array_merge($default, $options);

		$url = 'http://api.sc2ranks.com/v2/clans/characters/'.
			$region.'/'.$tag;

		return $this->post($url, $data);
	}

	public function getClanTeams($region, $tag, $options = array())
	{
		$default = array(
			'expansion' => $this->default['expansion'],
			'bracket' => $this->default['bracket'],
			'league' => $this->default['league'],
			'limit' => 50,
		);

		$data = array_merge($default, $options);

		$url = 'http://api.sc2ranks.com/v2/clans/teams/'.
			$region.'/'.$tag;

		return $this->post($url, $data);
	}

	public function getRankings($options = array())
	{
		$default = array(
			'rank_region' => $this->default['region'],
			'expansion' => $this->default['expansion'],
			'bracket' => $this->default['bracket'],
			'league' => $this->default['league'],
		);

		$data = array_merge($default, $options);

		$url = 'http://api.sc2ranks.com/v2/rankings';

		return $this->post($url, $data);
	}

	public function getDivisionList($options = array())
	{
		$default = array(
			'rank_region' => $this->default['region'],
			'expansion' => $this->default['expansion'],
			'bracket' => $this->default['bracket'],
			'league' => $this->default['league'],
		);

		$data = array_merge($default, $options);

		$url = 'http://api.sc2ranks.com/v2/divisions';

		return $this->post($url, $data);
	}

	public function getDivisionInfo($divId)
	{
		$url = 'http://api.sc2ranks.com/v2/divisions/'.$divId;

		return $this->post($url, array());
	}

	public function getDivisionTeams($divId, $limit = 10)
	{
		$url = 'http://api.sc2ranks.com/v2/divisions/teams/'.$divId;

		return $this->post($url, array('id' => $divId, 'limit' => $limit));
	}

	public function getCustomDivisions()
	{
		$url = 'http://api.sc2ranks.com/v2/custom-divisions';

		return $this->get($url);
	}

	public function getCdivInfo($cdivId)
	{
		$url = 'http://api.sc2ranks.com/v2/custom-divisions/'.$cdivId;

		return $this->post($url, array());
	}

	public function getCdivTeams($cdivId, array $options = array())
	{
		$default = array(
			'rank_region' => $this->default['region'],
			'expansion' => $this->default['expansion'],
			'bracket' => $this->default['bracket'],
			'league' => $this->default['league'],
			'limit' => 25,
		);

		$url = 'http://api.sc2ranks.com/v2/custom-divisions/teams/'.$cdivId;
		$data = array_merge($default, $options);

		return $this->post($url, $data);
	}

	public function getCdivCharacters($cdivId, array $options = array())
	{
		$default = array(
			'region' => $this->default['region'],
			'limit' => 25,
		);

		$data = array_merge($default, $options);
		
		$url = 'http://api.sc2ranks.com/v2/custom-divisions/characters/'.$cdivId;

		return $this->post($url, $data);
	}

	public function addCdivPlayer($cdivId, Player $player)
	{
		$url = 'http://api.sc2ranks.com/v2/custom-divisions/manage/'.$cdivId;

		$data = array('characters' => array($player->toArray()));

		return $this->post($url, $data);
	}

	public function addCdivPlayers($cdivId, array $players)
	{
		$url = 'http://api.sc2ranks.com/v2/custom-divisions/manage/'.$cdivId;

		$data = array('characters' => array());
		foreach ($players as $player) {
			$data['characters'][] = $player->toArray();
		}

		return $this->post($url, $data);
	}

	public function removeCdivPlayer($cdivId, Player $player)
	{
		$url = 'http://api.sc2ranks.com/v2/custom-divisions/manage/'.$cdivId;

		$data = array('characters' => array($player->toArray()));

		return $this->delete($url, $data);
	}

	public function removeCdivPlayers($cdivId, array $players)
	{
		$url = 'http://api.sc2ranks.com/v2/custom-divisions/manage/'.$cdivId;

		$data = array('characters' => array());
		foreach ($players as $player) {
			$data['characters'][] = $player->toArray();
		}

		return $this->delete($url, $data);
	}

	public function getRemainingCredits()
	{
		return $this->curl->getHeaders('X-Credits-Left');
	}

	public function getSumCreditsSpent()
	{
		return $this->sumCreditsSpent;
	}

	public function getCreditsSpent()
	{
		return $this->creditsSpent;
	}

	public function getCreditsSpentLast()
	{
		return $this->curl->getHeaders('X-Credits-Used');
	}

	protected function get($url, $query = array())
	{
		return $this->apiCall('get', $url, $query);
	}

	protected function post($url, $data = array(), $query = array())
	{
		return $this->apiCall('post', $url, $query, $data);
	}

	protected function delete($url, $data = array(), $query = array())
	{
		return $this->apiCall('delete', $url, $query, $data);
	}

	/**
	 * Make an API call to SC2ranks.
	 *
	 * @param  string $method get/post/delete
	 * @param  string $url
	 * @param  array  $query  query string
	 * @param  array  $data   post data
	 *
	 * @return array
	 */
	protected function apiCall($method, $url, array $query = array(), array $data = array())
	{
		$method = strtolower($method);

		if (!isset($query['api_key'])) {
			$query['api_key'] = $this->apiKey;
		}

		$this->validate($query);

		$url = $this->curl->buildUrl($url, $query);

		if ($method == 'get') {
			$result = $this->curl->get($url);
		} elseif ($method == 'post') {
			$result = $this->curl->post($url, $data);
		} elseif ($method == 'delete') {
			$result = $this->curl->delete($url, $data);
		}

		$resultData = $this->jsonDecode($result);

		if ($resultData === false) {
			throw new \UnexpectedValueException('Response did not contain valid JSON.');
		}

		$this->checkForErrors($resultData);

		$spent = $this->curl->getHeaders('X-Credits-Used');
		$this->creditsSpent[] = array(
			'method' => $method,
			'url' => $url,
			'credits' => $spent
		);
		$this->sumCreditsSpent += $spent;

		return $resultData;
	}

	/**
	 * Validate POST data to make sure it only contains allowed values.
	 *
	 * @see    $allowed
	 * @param  array $data
	 *
	 * @throws \InvalidArgumentException
	 * @return void
	 */
	protected function validate($data)
	{
		foreach ($data as $key => $val) {
			if (isset($this->allowed[$key]) && !in_array($val, $this->allowed[$key])) {
				throw new \InvalidArgumentException("$val is not an allowed $key");
			}
		}
	}

	/**
	 * Check a response for errors.
	 *
	 * @param  mixed $result
	 *
	 * @throws SC2RanksException
	 */
	protected function checkForErrors($result)
	{
		if (($this->returnArray && isset($result['error'])) || isset($result->error)) {
			throw new SC2RanksException('Error from SC2Ranks: '.$result->error);
		}
	}

	protected function jsonDecode($str)
	{
		if ($this->returnArray) {
			return json_decode($str, true);
		} else {
			return json_decode($str);
		}
	}

	protected function jsonEncode($str)
	{
		return json_encode($str);
	}
}
