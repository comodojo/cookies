<?php

class CookieTest extends \PHPUnit_Framework_TestCase {

    public function testCookieSave() {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://localhost/tests/resources/SetCookie.php');

        curl_setopt($ch, CURLOPT_PORT, 8000);

        curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__."/../tmp/COOKIE_TMP");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER,  1);

        $request = curl_exec($ch);

        $result = json_decode($request, true);

        foreach ($result as $key => $value) {

            $this->assertTrue($value);

        }

        curl_close($ch);

    }

    public function testCookieLoad() {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://localhost/tests/resources/GetCookie.php');

        curl_setopt($ch, CURLOPT_PORT, 8000);

        curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__."/../tmp/COOKIE_TMP");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER,  1);

        $request = curl_exec($ch);

        $result = json_decode($request, true);

        $this->assertSame($result["cookie_1"], "cookie-1");
        $this->assertSame($result["cookie_2"], "cookie-2");
        $this->assertSame($result["cookie_3"], "Cookie does not exists");
        $this->assertStringStartsWith('expiry time', $result["cookie_4"]);
        $this->assertSame($result["cookie_5"], "Cookie does not exists");

        curl_close($ch);

    }

    /**
     * @expectedException        Comodojo\Exception\CookieException
     */
    public function testCookieMaxLength() {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < 5000; $i++) {
    
            $randomString .= $characters[rand(0, $charactersLength - 1)];
    
        }

        $cookie = new \Comodojo\Cookies\Cookie('cookie_maxl');

        $cookie->setValue($randomString);

    }

    public function testConstruct() {

        $cookie = new \Comodojo\Cookies\Cookie('test_cookie');

        $this->assertInstanceOf('\Comodojo\Cookies\Cookie', $cookie);

    }

    public function testSetGetStringValue() {

        $value = 'this is a sample value';

        $cookie = new \Comodojo\Cookies\Cookie('test_cookie');

        $result = $cookie->setValue($value);

        $this->assertInstanceOf('\Comodojo\Cookies\Cookie', $cookie);

        $result = $cookie->getValue();

        $this->assertEquals($value, $result);

    }

    public function testGetValueUnserialized() {

        $value = 'this is a sample value';

        $cookie = new \Comodojo\Cookies\Cookie('test_cookie');

        $result = $cookie->setValue($value, false);

        $this->assertInstanceOf('\Comodojo\Cookies\Cookie', $cookie);

        $result = $cookie->getValue(false);

        $this->assertEquals($value, $result);

    }

    public function testSetGetArrayValue() {

        $value = array("this","is","a","sample","value");

        $cookie = new \Comodojo\Cookies\Cookie('test_cookie');

        $result = $cookie->setValue($value);

        $this->assertInstanceOf('\Comodojo\Cookies\Cookie', $cookie);

        $result = $cookie->getValue();

        $this->assertEquals($value, $result);

    }

    public function testCreate() {

        $cookie = \Comodojo\Cookies\Cookie::create('test_cookie');

        $this->assertInstanceOf('\Comodojo\Cookies\Cookie', $cookie);        

    }
    
    /**
     * @expectedException        Comodojo\Exception\CookieException
     */
    public function testRetrieve() {

        $cookie = \Comodojo\Cookies\Cookie::retrieve('test_cookie');

    }

    public static function tearDownAfterClass() {

        unlink(__DIR__."/../tmp/COOKIE_TMP");

    }

}