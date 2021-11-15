<?php

use Comodojo\Cookies\EncryptedCookie;
use Comodojo\Exception\CookieException;

require __DIR__.'/../../vendor/autoload.php';

ob_start();

$cookies = [];

$cookie_1 = new EncryptedCookie('cookie_1',"thisismyverycomplexpassword");
$cookies['cookie_1'] = $cookie_1->load()->getValue();

// create cookie with static method create
$cookies['cookie_2'] = EncryptedCookie::retrieve('cookie_2',"thisismyverycomplexpassword")->getValue();

try {
	$cookies['cookie_3'] = EncryptedCookie::retrieve('cookie_3',"thisismyverycomplexpassword")->getValue();
} catch (CookieException $ce) {
	$cookies['cookie_3'] = $ce->getMessage();
}

$cookies['cookie_4'] = EncryptedCookie::retrieve('cookie_4',"thisismyverycomplexpassword")->getValue();

try {
	$cookies['cookie_5'] = EncryptedCookie::retrieve('cookie_5',"thisismyverycomplexpassword")->getValue();
} catch (CookieException $ce) {
	$cookies['cookie_5'] = $ce->getMessage();
}

ob_end_clean();
echo json_encode($cookies);