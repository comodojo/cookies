<?php declare(strict_types=1);

namespace Comodojo\Cookies\Tests;

use \PHPUnit\Framework\TestCase;
use \Comodojo\Cookies\Tests\Utils\Request;
use \Comodojo\Cookies\Cookie;

class CookieTest extends TestCase
{

    protected const COOKIE_JAR = __DIR__ . "/../../tmp/COOKIE_TMP";

    public function testCookieSave()
    {
        $result = Request::send('http://localhost/SetCookie.php', self::COOKIE_JAR);
        foreach ($result as $value) {
            $this->assertTrue($value);
        }
    }

    public function testCookieLoad()
    {
        $result = Request::send('http://localhost/GetCookie.php', self::COOKIE_JAR, true);
        $this->assertSame($result["cookie_1"], "cookie-1");
        $this->assertSame($result["cookie_2"], "cookie-2");
        $this->assertSame($result["cookie_3"], "Cookie cookie_3 does not exists");
        $this->assertStringStartsWith('expiry time', $result["cookie_4"]);
        $this->assertSame($result["cookie_5"], "Cookie cookie_5 does not exists");
    }

    public function testCookieMaxLength()
    {
        $this->expectException("\Comodojo\Exception\CookieException");

        $randomString = bin2hex(random_bytes(5000));
        $cookie = new Cookie('cookie_maxl');
        $cookie->setValue($randomString);
    }

    public function testSetGetStringValue()
    {
        $value = 'this is a sample value';
        $cookie = new Cookie('test_cookie');

        $result = $cookie->setValue($value);
        $this->assertInstanceOf('\Comodojo\Cookies\Cookie', $cookie);

        $result = $cookie->getValue();
        $this->assertEquals($value, $result);
    }

    public function testGetValueUnserialized()
    {
        $value = 'this is a sample value';
        $cookie = new Cookie('test_cookie');

        $result = $cookie->setValue($value, false);
        $this->assertInstanceOf('\Comodojo\Cookies\Cookie', $cookie);

        $result = $cookie->getValue(false);
        $this->assertEquals($value, $result);
    }

    public function testCreate()
    {
        $cookie = Cookie::create('test_cookie');
        $this->assertInstanceOf('\Comodojo\Cookies\Cookie', $cookie);
    }

    public function testRetrieve()
    {
        $this->expectException("\Comodojo\Exception\CookieException");

        Cookie::retrieve('test_cookie');
    }

    public static function tearDownAfterClass(): void
    {
        unlink(self::COOKIE_JAR);
    }
}
