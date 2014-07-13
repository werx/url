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

	public function testCanGenerateActionUrlWithId()
	{
		$builder = $this->getBuilderRootRelativeUrl();

		# With leading slash
		$this->assertEquals('/app/index.php/home/details/1', $builder->action('/home/details/{id}', 1));
		$this->assertEquals('/app/index.php/home/details/1', $builder->action('/home/details/{id}', '1'));

		# Without leading slash
		$this->assertEquals('/app/index.php/home/details/1', $builder->action('home/details/{id}', 1));
		$this->assertEquals('/app/index.php/home/details/1', $builder->action('home/details/{id}', '1'));

		$builder = $this->getBuilderAbsoluteUrl();

		# With leading slash
		$this->assertEquals('http://www.example.com/app/index.php/home/details/1', $builder->action('/home/details/{id}', 1));
		$this->assertEquals('http://www.example.com/app/index.php/home/details/1', $builder->action('/home/details/{id}', '1'));

		# Without leading slash
		$this->assertEquals('http://www.example.com/app/index.php/home/details/1', $builder->action('home/details/{id}', 1));
		$this->assertEquals('http://www.example.com/app/index.php/home/details/1', $builder->action('home/details/{id}', '1'));

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

	public function testCanGenerateAssetUr()
	{
		$builder = $this->getBuilderRootRelativeUrl();
		$this->assertEquals('/app/images/foo.jpg', $builder->asset('/images/foo.jpg'));
		$this->assertEquals('/app/images/foo.jpg', $builder->asset('images/foo.jpg'));

		$builder = $this->getBuilderAbsoluteUrl();
		$this->assertEquals('http://www.example.com/app/images/foo.jpg', $builder->asset('/images/foo.jpg'));
		$this->assertEquals('http://www.example.com/app/images/foo.jpg', $builder->asset('images/foo.jpg'));
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
