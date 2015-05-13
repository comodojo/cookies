<?php

/**
 * @runTestsInSeparateProcesses
 */
class CookieTest extends \PHPUnit_Framework_TestCase {

    public function testCookieSave() {

        $cookieContent = 'this is a plain cookie';
        
        $cookie = new \Comodojo\Cookies\Cookie('comodojo');

        $save = $cookie->setValue($cookieContent)->save();

        $this->assertTrue($save);

        //$new_cookie = new \Comodojo\Cookies\Cookie('comodojo');

        //$load = $new_cookie->load()->getValue();

        //$this->assertSame($cookieContent, $load);

    }

}
