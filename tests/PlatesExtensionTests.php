<?php
namespace werx\Url\Tests;

class PlatesExtensionTests extends \PHPUnit_Framework_TestCase
{

	public function testActionMethodExists()
	{
		$engine = new \League\Plates\Engine;
		$ext = new \werx\Url\Extensions\Plates;
		$engine->loadExtension($ext);

		$template = new \League\Plates\Template($engine);

		$this->assertTrue(method_exists($template->url(), 'action'), 'The action method from werx\Url\Builder should be available');
	}

	public function testGetFunctionsReturnsArray()
	{
		$ext = new \werx\Url\Extensions\Plates;
		$this->assertArrayHasKey('url', $ext->getFunctions());
	}
}
