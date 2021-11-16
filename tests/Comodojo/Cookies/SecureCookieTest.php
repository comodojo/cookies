<?php

declare(strict_types=1);

namespace Comodojo\Cookies\Tests;

use \PHPUnit\Framework\TestCase;
use \Comodojo\Cookies\Tests\Utils\Request;
use \Comodojo\Cookies\SecureCookie;

class SecureCookieTest extends TestCase
{

    protected const COOKIE_JAR = __DIR__ . "/../../tmp/SECURE_COOKIE_TMP";

    public function testCookieSave()
    {
        $result = Request::send('http://localhost/SetSecureCookie.php', self::COOKIE_JAR);
        foreach ($result as $value) {
            $this->assertTrue($value);
        }
    }

    public function testCookieLoad()
    {
        $result = Request::send('http://localhost/GetSecureCookie.php', self::COOKIE_JAR, true);
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
        $cookie = new SecureCookie('cookie_maxl', "secretpass");
        $cookie->setValue($randomString);
    }

    public function testConstruct()
    {
        $cookie = new SecureCookie('test_cookie', 'test_key');
        $this->assertInstanceOf('\Comodojo\Cookies\SecureCookie', $cookie);
    }

    public function testSetGetStringValue()
    {
        $value = 'this is a sample value';
        $cookie = new SecureCookie('test_cookie', 'test_key');

        $result = $cookie->setValue($value);
        $this->assertInstanceOf('\Comodojo\Cookies\SecureCookie', $cookie);

        $result = $cookie->getValue();
        $this->assertEquals($value, $result);
    }

    public function testGetValueUnserialized()
    {
        $value = 'this is a sample value';
        $cookie = new SecureCookie('test_cookie', 'test_key');

        $result = $cookie->setValue($value, false);
        $this->assertInstanceOf('\Comodojo\Cookies\SecureCookie', $cookie);

        $result = $cookie->getValue(false);
        $this->assertEquals($value, $result);
    }

    public function testCreate()
    {
        $cookie = SecureCookie::create('test_cookie', 'test_key');
        $this->assertInstanceOf('\Comodojo\Cookies\SecureCookie', $cookie);
    }

    public function testRetrieve()
    {
        $this->expectException("\Comodojo\Exception\CookieException");
        SecureCookie::retrieve('test_cookie', 'test_key');
    }

    public static function tearDownAfterClass(): void
    {
        unlink(self::COOKIE_JAR);
    }
}
