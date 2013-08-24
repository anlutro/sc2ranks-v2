<?php
namespace anlutro\SC2Ranks;

class cURL
{
	protected $headers = array();

	protected $lastResponse;

	protected $lastResponseInfo;

	protected $lastResponseHeaders;

	public function get($url, array $query = array())
	{
		$this->init();
		
		if (!empty($query)) {
			$queryString = http_build_query($query);
			$url .= '?' . $queryString;
		}

		$this->setUrl($url);

		return $this->exec();
	}

	public function post($url, array $query = array(), array $data = array())
	{
		$this->init();

		if (!empty($query)) {
			$queryString = http_build_query($query);
			$url .= '?' . $queryString;
		}

		$this->setUrl($url);

		$this->isPost(true);
		$this->setPostData($data);

		return $this->exec();
	}

	public function delete($url, array $query = array(), array $data = array())
	{
		$this->init();

		if (!empty($query)) {
			$queryString = http_build_query($query);
			$url .= '?' . $queryString;
		}

		$this->setUrl($url);

		curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		$this->setPostData($data);

		return $this->exec();
	}

	protected function init()
	{
		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->ch, CURLOPT_HEADER, true);
	}

	protected function setUrl($url)
	{
		curl_setopt($this->ch, CURLOPT_URL, $url);
	}

	protected function isPost($val)
	{
		curl_setopt($this->ch, CURLOPT_POST, $val);
	}

	protected function setPostData($data)
	{
		$postData = http_build_query($data);
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
	}

	public function addHeader($value)
	{
		$this->headers[] = $value;
	}

	public function getHeaders($header = null)
	{
		if (!$header)
			return $this->lastResponseHeaders;

		if (array_key_exists($header, $this->lastResponseHeaders))
			return $this->lastResponseHeaders[$header];
	}

	public function getInfo()
	{
		return $this->lastResponseInfo;
	}

	protected function exec()
	{
		curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);

		$response = curl_exec($this->ch);

		$this->extractCurlInfo($response);

		curl_close($this->ch);

		return $this->lastResponseBody;
	}

	protected function extractCurlInfo($response)
	{
		$this->lastResponse = $response;

		$this->lastResponseInfo = curl_getinfo($this->ch);

		$headerSize = curl_getinfo($this->ch, CURLINFO_HEADER_SIZE);
		$headerText = substr($response, 0, $headerSize);
		$this->lastResponseHeaders = $this->headerToArray($headerText);

		$this->lastResponseBody = substr($response, $headerSize);
	}

	protected function headerToArray($header)
	{
		$tmp = explode("\r\n", $header);
		$headers = array();
		foreach ($tmp as $singleHeader) {
			$delimiter = strpos($singleHeader, ': ');
			if ($delimiter !== false) {
				$key = substr($singleHeader, 0, $delimiter);
				$val = substr($singleHeader, $delimiter + 2);
				$headers[$key] = $val;
			} else {
				$delimiter = strpos($singleHeader, ' ');
				if ($delimiter !== false) {
					$key = substr($singleHeader, 0, $delimiter);
					$val = substr($singleHeader, $delimiter + 1);
					$headers[$key] = $val;
				}
			}
		}
		return $headers;
	}
}
