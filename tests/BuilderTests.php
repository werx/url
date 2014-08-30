<?php
namespace werx\Url\Tests;

use werx\Url\Builder;

class BuilderTests extends \PHPUnit_Framework_TestCase
{
	public function testCanGenerateActionUrlWithNamedParams()
	{
		$builder = $this->getBuilderRootRelativeUrl();
		$this->assertEquals('/app/index.php/home/index', $builder->action('/{controller}/{action}', ['controller'=>'home', 'action' => 'index']));
		$this->assertEquals('/app/index.php/home/index', $builder->action('{controller}/{action}', ['controller'=>'home', 'action' => 'index']));

		$builder = $this->getBuilderAbsoluteUrl();
		$this->assertEquals('http://www.example.com/app/index.php/home/index', $builder->action('/{controller}/{action}', ['controller'=>'home', 'action' => 'index']));
		$this->assertEquals('http://www.example.com/app/index.php/home/index', $builder->action('{controller}/{action}', ['controller'=>'home', 'action' => 'index']));
	}

	public function testCanGenerateRelativeActionUrlWithId()
	{
		$builder = $this->getBuilderRootRelativeUrl();
		$expected = '/app/index.php/home/details/1';
		$this->subtestCanGenerateActionUrlWithId($expected, $builder);
	}

	public function testCanGenerateAbsoluteActionUrlWithId()
	{
		$builder = $this->getBuilderAbsoluteUrl();
		$expected = 'http://www.example.com/app/index.php/home/details/1';
		$this->subtestCanGenerateActionUrlWithId($expected, $builder);
	}

	public function subtestCanGenerateActionUrlWithId($expected, $builder)
	{
		# With leading slash
		$this->assertEquals($expected, $builder->action('/home/details/{id}', 1));
		$this->assertEquals($expected, $builder->action('/home/details/{id}', '1'));
		$this->assertEquals($expected, $builder->action('/home/details/', 1));
		$this->assertEquals($expected, $builder->action('/home/details/', '1'));
		$this->assertEquals($expected, $builder->action('/home/details', 1));
		$this->assertEquals($expected, $builder->action('/home/details', '1'));
	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Invalid params
	 */
	public function testInvalidActionParamsShouldThrowException()
	{
		$builder = $this->getBuilderRootRelativeUrl();

		$params = new \stdClass();
		$builder->action('home/details/', $params);
	}

	public function testGenerateActionUrlWithNullParams()
	{
		$builder = $this->getBuilderRootRelativeUrl();
		$expected = '/app/index.php/home/details';

		$this->assertEquals($expected, $builder->action('home/details/'));
		$this->assertEquals($expected, $builder->action('home/details'));
	}

	public function testCanGenerateActionUrlWithQueryString()
	{
		$builder = $this->getBuilderRootRelativeUrl();
		$this->assertEquals('/app/index.php/home/search?foo=Foo&bar=Bar', $builder->query('/home/search', ['foo' => 'Foo', 'bar' => 'Bar']));
		$this->assertEquals('/app/index.php/home/search?foo=Foo&bar=Bar', $builder->query('home/search', ['foo' => 'Foo', 'bar' => 'Bar']));

		$builder = $this->getBuilderAbsoluteUrl();
		$this->assertEquals('http://www.example.com/app/index.php/home/search?foo=Foo&bar=Bar', $builder->query('/home/search', ['foo' => 'Foo', 'bar' => 'Bar']));
		$this->assertEquals('http://www.example.com/app/index.php/home/search?foo=Foo&bar=Bar', $builder->query('home/search', ['foo' => 'Foo', 'bar' => 'Bar']));

	}

	public function testCanGenerateAssetUrl()
	{
		$builder = $this->getBuilderRootRelativeUrl();
		$this->assertEquals('/app/images/foo.jpg', $builder->asset('/images/foo.jpg'));
		$this->assertEquals('/app/images/foo.jpg', $builder->asset('images/foo.jpg'));

		$builder = $this->getBuilderAbsoluteUrl();
		$this->assertEquals('http://www.example.com/app/images/foo.jpg', $builder->asset('/images/foo.jpg'));
		$this->assertEquals('http://www.example.com/app/images/foo.jpg', $builder->asset('images/foo.jpg'));
	}

	public function testCanGenerateRootActionUrl()
	{
		$builder = $this->getBuilderRootRelativeUrl();

		$this->assertEquals('/app/index.php', $builder->action('/'));
		$this->assertEquals('/app/index.php', $builder->action());
	}

	public function getBuilderAbsoluteUrl()
	{
		return new Builder('http://www.example.com/app/', 'index.php');
	}

	/**
	 * @return Builder
	 */
	public function getBuilderRootRelativeUrl()
	{
		return new Builder('/app/', 'index.php');
	}
}
