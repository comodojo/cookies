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

    public static function tearDownAfterClass() {

        unlink(__DIR__."/../tmp/MANAGER_COOKIE_TMP");

    }

}
