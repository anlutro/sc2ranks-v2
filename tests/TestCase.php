<?php
use anlutro\SC2Ranks\SC2Ranks;
use Mockery as m;

class TestCase extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->curl = m::mock('anlutro\cURL\cURL')->makePartial();
		$this->curl->shouldReceive('getHeaders')->with('X-Credits-Used');
		$this->apiKey = array('api_key' => 'test_api_key');
		$this->sc2r = new SC2Ranks('test_api_key', $this->curl);
	}

	public function tearDown()
	{
		m::close();
	}

	protected function dataFile($file)
	{
		return file_get_contents(__DIR__ . '/data/' . $file . '.json');
	}

	protected function expectPost($url, $data = array())
	{
		$that = $this;
		$url = $this->curl->buildUrl($url, $this->apiKey);

		return $this->curl->shouldReceive('post')->once()
			->with(m::on(function($postUrl) use($url, $that) {
				$that->assertEquals($postUrl, $url);
				return true;
			}),
			m::on(function($post) use($data, $that) {
				foreach ($data as $key => $val) {
					$that->assertArrayHasKey($key, $post, 'POST data missing');
					$that->assertEquals($post[$key], $val, 'POST data mismatch');
				}
				return true;
			}));
	}

	protected function expectDelete($url, $data = array())
	{
		$that = $this;
		$url = $this->curl->buildUrl($url, $this->apiKey);

		return $this->curl->shouldReceive('delete')->once()
			->with(m::on(function($delUrl) use($url, $that) {
				$that->assertEquals($delUrl, $url);
				return true;
			}),
			m::on(function($del) use($data, $that) {
				foreach ($data as $key => $val) {
					$that->assertArrayHasKey($key, $del, 'DELETE data missing');
					$that->assertEquals($del[$key], $val, 'DELETE data mismatch');
				}
				return true;
			}));
	}

	protected function expectGet($url)
	{
		$that = $this;
		$url = $this->curl->buildUrl($url, $this->apiKey);

		return $this->curl->shouldReceive('get')->once()
			->with(m::on(function($postUrl) use($url, $that) {
				$that->assertEquals($postUrl, $url);
				return true;
			}));
	}
}
