<?php declare(strict_types=1);

namespace Comodojo\Cookies\Tests;

use \PHPUnit\Framework\TestCase;
use \Comodojo\Cookies\Cookie;

class CookieBaseTest extends TestCase
{
	protected $cookie_name = 'basecookietest';

	protected function setUp(): void
	{
		$this->cookie = new Cookie($this->cookie_name);
	}

	protected function tearDown(): void
	{
		unset($this->cookie);
	}

	public function testGetName()
	{
		$result = $this->cookie->getName();
		$this->assertEquals($this->cookie_name, $result);
	}

	public function testSetExpire()
	{
		$result = $this->cookie->setExpire(time() + 3600);
		$this->assertInstanceOf('\Comodojo\Cookies\Cookie', $result);
	}

	public function testSetPath()
	{
		$result = $this->cookie->setPath('/');
		$this->assertInstanceOf('\Comodojo\Cookies\Cookie', $result);
	}

	public function testSetDomain()
	{
		$result = $this->cookie->setDomain('comodojo.org');
		$this->assertInstanceOf('\Comodojo\Cookies\Cookie', $result);
	}

	public function testSetSecure()
	{
		$result = $this->cookie->setSecure();
		$this->assertInstanceOf('\Comodojo\Cookies\Cookie', $result);
	}

	public function testSetHttponly()
	{
		$result = $this->cookie->setHttponly();
		$this->assertInstanceOf('\Comodojo\Cookies\Cookie', $result);
	}

	public function testLoad()
	{
		$this->expectException("\Comodojo\Exception\CookieException");
		$this->cookie->load();
	}

	public function testDelete()
	{
		$result = $this->cookie->delete();
		$this->assertTrue($result);
	}

	public function testExists()
	{
		$result = $this->cookie->exists();
		$this->assertFalse($result);
	}

	public function testErase()
	{
		$result = Cookie::erase($this->cookie_name);
		$this->assertTrue($result);
	}
}
