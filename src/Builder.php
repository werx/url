<?php

namespace werx\Url;

use Rize\UriTemplate;

class Builder
{
	public $base_url = null;
	public $script_name = null;

	public function __construct($url = null, $script_name = null)
	{
		$this->setBaseUrl($url);
		$this->setScriptName($script_name);
	}

	public function setBaseUrl($url = null)
	{
		if (empty($url)) {
			$url = dirname($_SERVER['SCRIPT_NAME']) . '/';
		}

		$this->base_url = $url;
	}

	public function setScriptName($name = null)
	{

		if (empty($name)) {
			$name = basename($_SERVER['SCRIPT_NAME']);
		}

		$this->script_name = $name;
	}

	public function getBaseUrl($include_script_name = true)
	{

		$base_url = rtrim($this->base_url, '/');

		if ($include_script_name) {
			# http://example.com/app/index.php
			return sprintf('%s/%s', $base_url, $this->script_name);
		} else {
			# http://example.com/app/
			return $base_url;
		}
	}

	public function action($uri = null, $params = [])
	{
		$template = new UriTemplate($this->getBaseUrl(true));

		$uri = '/' . trim($uri, '/');

		// Build a url using string replacements in a pattern.
		if (is_array($params)) {
			return $template->expand($uri, $params);
		} elseif ((is_string($params) || is_int($params))) {

			if (preg_match('/\{id\}/', $uri)) {
				# /app/index.php/home/details/1
				return $template->expand($uri, ['id' => $params]);
			} else {
				return $template->expand(rtrim($uri, '/') . '/' . $params);
			}
		} else {
			throw new \Exception('Invalid params');
		}
	}

	public function asset($resource = null, $params = [])
	{
		# http://example.com/app/images/foo.jpg
		$template = new UriTemplate($this->getBaseUrl(false));

		$resource = '/' . ltrim($resource, '/');
		return $template->expand($resource, $params);
	}

	public function query($uri = null, $params = [])
	{
		$uri = '/' . trim($uri, '/');

		# http://example.com/app/index.php/home/search?name=Josh
		return $this->getBaseUrl(true) . $uri . '?' . http_build_query($params);
	}
}
