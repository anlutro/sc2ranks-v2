<?php
namespace anlutro\SC2Ranks;

class Player
{
	public $region;
	public $bnetId;

	public function __construct($region=null, $bnetId=null)
	{
		$this->region = $region;
		$this->bnetId = $bnetId;
	}

	public function parseUrl($url)
	{
		if (strpos($url, 'battle.net') !== FALSE) {
			$url = explode('/', $url);
			$this->region = substr($url[2], 0, strpos($url[2], '.'));
			$this->bnetId = $url[6];
		} elseif (strpos($url, 'sc2ranks.com') !== FALSE) {
			$url = explode('/', $url);
			$this->region = $url[4];
			$this->bnetId = $url[5];
		} else {
			throw new \InvalidArgumentException('Invalid Battle.net/SC2Ranks URL');
		}
	}

	public function toArray()
	{
		return array(
			'region' => $this->region,
			'bnet_id' => $this->bnetId,
		);
	}
}
