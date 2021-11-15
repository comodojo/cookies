<?php declare(strict_types=1);

namespace Comodojo\Cookies\Tests;

use \PHPUnit\Framework\TestCase;
use \Comodojo\Cookies\Tests\Utils\Request;
use \Comodojo\Cookies\Cookie;
use \Comodojo\Cookies\CookieManager;

class CookieManagerTest extends TestCase
{

    private const COOKIE_JAR = __DIR__ . "/../../tmp/MANAGER_COOKIE_TMP";

    public function testCookieSave()
    {
        $result = Request::send('http://localhost/SetCookieManager.php', self::COOKIE_JAR);
        $this->assertTrue($result["manager"]);
    }

    public function testCookieLoad()
    {
        $result = Request::send('http://localhost/GetCookieManager.php', self::COOKIE_JAR, true);
        $this->assertSame($result["cookie_1"], "cookie-1");
        $this->assertSame($result["cookie_2"], "cookie-2");
    }

    public function testManagerCookiesHandling()
    {
        $cookie = new Cookie('test_cookie');
        $manager = new CookieManager();

        $result = $manager->add($cookie);
        $this->assertInstanceOf('\Comodojo\Cookies\CookieManager', $result);

        $result = $manager->has('test_cookie');
        $this->assertTrue($result);

        $result = $manager->has($cookie);
        $this->assertTrue($result);

        $result = $manager->get('test_cookie');
        $this->assertInstanceOf('\Comodojo\Cookies\Cookie', $result);

        $result = $manager->delete('test_cookie');
        $this->assertInstanceOf('\Comodojo\Cookies\CookieManager', $result);
    }

    public function testManagerGetValues()
    {
        $cookie1 = new Cookie('test_cookie_1');
        $cookie1->setValue('value1');

        $cookie2 = new Cookie('test_cookie_2');
        $cookie2->setValue('value2');

        $manager = new CookieManager();
        $manager
            ->add($cookie1)
            ->add($cookie2);
        $result = $manager->getValues();

        $this->assertIsArray($result);
        $this->assertArrayHasKey("test_cookie_1", $result);
        $this->assertArrayHasKey("test_cookie_2", $result);
        $this->assertEquals('value1', $result['test_cookie_1']);
        $this->assertEquals('value2', $result['test_cookie_2']);
    }

    public static function tearDownAfterClass(): void
    {
        unlink(self::COOKIE_JAR);
    }
}
