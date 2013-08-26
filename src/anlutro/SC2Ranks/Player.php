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

	public function toArray()
	{
		return array(
			'region' => $this->region,
			'bnet_id' => $this->bnetId,
		);
	}
}
