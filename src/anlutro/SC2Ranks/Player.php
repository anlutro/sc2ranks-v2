<?php
/**
 * SC2Ranks v2 API - PHP library
 * 
 * @author  Andreas Lutro <anlutro@gmail.com>
 * @license http://opensource.org/licenses/MIT
 * @package anlutro/sc2ranks-v2
 */

namespace anlutro\SC2Ranks;

/**
 * Class for storing player data in SC2ranks context.
 */
class Player
{
	public $region;
	public $bnetId;

	/**
	 * @param string $region eu/am etc.
	 * @param string $bnetId Should be numeric
	 */
	public function __construct($region = null, $bnetId = null)
	{
		$this->region = $region;
		$this->bnetId = $bnetId;
	}

	/**
	 * Parse a battle.net or sc2ranks url, extracting region and bnetID.
	 *
	 * @param  string $url
	 *
	 * @return void
	 */
	public function parseUrl($url)
	{
		$url = str_replace('http://', '', $url);

		if (strpos($url, 'battle.net') !== FALSE) {
			$url = explode('/', $url);
			$this->region = substr($url[0], 0, strpos($url[0], '.'));
			$this->bnetId = $url[4];
		} elseif (strpos($url, 'sc2ranks.com') !== FALSE) {
			$url = explode('/', $url);
			$this->region = $url[2];
			$this->bnetId = $url[3];
		} else {
			throw new \InvalidArgumentException('Invalid Battle.net/SC2Ranks URL');
		}
	}

	/**
	 * Cast the player to an array that can be passed as POST data to the
	 * SC2Ranks API.
	 *
	 * @return array
	 */
	public function toArray()
	{
		return array(
			'region' => $this->region,
			'bnet_id' => $this->bnetId,
		);
	}
}
