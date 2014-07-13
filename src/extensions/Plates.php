<?php

namespace werx\Url\Extensions;

class Plates extends \werx\Url\Builder implements \League\Plates\Extension\ExtensionInterface
{
	public function getFunctions()
	{
		return ['url' => 'getUrlObject'];
	}

	public function getUrlObject()
	{
		return $this;
	}
}
