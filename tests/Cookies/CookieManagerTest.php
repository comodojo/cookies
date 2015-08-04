<?php

class CookieManagerTest extends \PHPUnit_Framework_TestCase {

    public function testCookieSave() {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://localhost/tests/resources/SetCookieManager.php');

        curl_setopt($ch, CURLOPT_PORT, 8000);

        curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__."/../tmp/MANAGER_COOKIE_TMP");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER,  1);

        $request = curl_exec($ch);

        $result = json_decode($request, true);

        $this->assertTrue($result["manager"]);

        curl_close($ch);

    }

    public function testCookieLoad() {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://localhost/tests/resources/GetCookieManager.php');

        curl_setopt($ch, CURLOPT_PORT, 8000);

        curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__."/../tmp/MANAGER_COOKIE_TMP");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER,  1);

        $request = curl_exec($ch);

        $result = json_decode($request, true);

        $this->assertSame($result["cookie_1"], "cookie-1");
        $this->assertSame($result["cookie_2"], "cookie-2");

        curl_close($ch);

    }

    public function testManagerCookiesHandling() {

        $cookie = new \Comodojo\Cookies\Cookie('test_cookie');

        $manager = new \Comodojo\Cookies\CookieManager();

        $result = $manager->register($cookie);

        $this->assertInstanceOf('\Comodojo\Cookies\CookieManager', $result);

        $result = $manager->isRegistered('test_cookie');

        $this->assertTrue($result);

        $result = $manager->isRegistered($cookie);

        $this->assertTrue($result);

        $result = $manager->get('test_cookie');

        $this->assertInstanceOf('\Comodojo\Cookies\Cookie', $result);

        $result = $manager->unregister('test_cookie');

        $this->assertInstanceOf('\Comodojo\Cookies\CookieManager', $result);

    }

    public function testManagerGetValues() {

        $cookie1 = new \Comodojo\Cookies\Cookie('test_cookie_1');

        $cookie1->setValue('value1');

        $cookie2 = new \Comodojo\Cookies\Cookie('test_cookie_2');

        $cookie2->setValue('value2');

        $manager = new \Comodojo\Cookies\CookieManager();

        $manager->register($cookie1)->register($cookie2);

        $result = $manager->getValues();

        $this->assertInternalType('array', $result);

        $this->assertArrayHasKey("test_cookie_1", $result);

        $this->assertArrayHasKey("test_cookie_2", $result);

        $this->assertEquals('value1', $result['test_cookie_1']);

        $this->assertEquals('value2', $result['test_cookie_2']);

    }

    public static function tearDownAfterClass() {

        unlink(__DIR__."/../tmp/MANAGER_COOKIE_TMP");

    }

}
