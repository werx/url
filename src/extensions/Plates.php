<?php

namespace werx\Url\Extensions;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class Plates extends \werx\Url\Builder implements ExtensionInterface
{
	public function register(Engine $engine)
	{
		$engine->registerFunction('url', [$this, 'getUrlObject']);
	}

	public function getUrlObject()
	{
		return $this;
	}

	/**
	 * Get the defined extension functions.
	 * @return array
	 */
	public function getFunctions()
	{
		return ['url' => 'getUrlObject'];
	}
}
