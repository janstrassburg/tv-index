<?php

namespace JanStrassburg\TvIndex\Service;

use Unirest\Request;
use Unirest\Response;

class Trakt {

	/**
	 * @var array
	 */
	private $config;

	function __construct(array $config) {
		$this->config = $config;
	}

	/**
	 * @param string $url
	 * @return array
	 */
	private function makeRequest($url) {
		$headers = array(
			"Content-Type" => "application/json",
			"trakt-api-version" => "2",
			"trakt-api-key" => $this->config['api_key']
		);
		Request::verifyPeer(false);
		/** @var Response $response */
		$response = Request::get($this->config['url'] . $url, $headers);
		return json_decode($response->raw_body, true);
	}

	/**
	 * @param string $showName
	 * @return array
	 */
	public function search($showName) {
		return $this->makeRequest('search?type=show&query=' . urlencode($showName));
	}

}
