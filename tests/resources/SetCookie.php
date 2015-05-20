<?php

use Comodojo\Cookies\Cookie;

require __DIR__.'/../../vendor/autoload.php';

ob_start();

// create cookie with class constructor

$cookies = array();

$cookie_1 = new Cookie('cookie_1');

$cookies['cookie_1'] = $cookie_1->setValue("cookie-1")->save();

// create cookie with static method create

$cookies['cookie_2'] = Cookie::create('cookie_2',array('value'=>'cookie-2'))->save();

// delete a cookie (should return a CookieException when retrieved)

$cookie_3 = new Cookie('cookie_3');

$cookies['cookie_3'] = $cookie_3->setValue('bla')->delete();

// set a cookie expiration timestamp

$cookie_4 = new Cookie('cookie_4');

$time = time();

$cookies['cookie_4'] = $cookie_4->setValue("expiry time: ".$time)->setExpire($time+3600)->save();

// set a cookie for another domain (should return a CookieException when retrieved)

$cookie_5 = new Cookie('cookie_5');

$time = time();

$cookies['cookie_5'] = $cookie_5->setValue("cookie for www.example.com")->setDomain("www.example.com")->save();

ob_end_clean();

echo json_encode($cookies);