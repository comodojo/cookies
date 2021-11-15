<?php

use Comodojo\Cookies\Cookie;
use Comodojo\Exception\CookieException;

require __DIR__.'/../../vendor/autoload.php';

ob_start();

$cookies = [];

$cookie_1 = new Cookie('cookie_1');
$cookies['cookie_1'] = $cookie_1->load()->getValue();

// create cookie with static method create
$cookies['cookie_2'] = Cookie::retrieve('cookie_2')->getValue();

try {
	$cookies['cookie_3'] = Cookie::retrieve('cookie_3')->getValue();
} catch (CookieException $ce) {
	$cookies['cookie_3'] = $ce->getMessage();
}

$cookies['cookie_4'] = Cookie::retrieve('cookie_4')->getValue();

try {	
	$cookies['cookie_5'] = Cookie::retrieve('cookie_5')->getValue();
} catch (CookieException $ce) {
	$cookies['cookie_5'] = $ce->getMessage();
}

ob_end_clean();

echo json_encode($cookies);