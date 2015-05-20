<?php

use Comodojo\Cookies\Cookie;
use Comodojo\Cookies\SecureCookie;
use Comodojo\Cookies\CookieManager;
use Comodojo\Exception\CookieException;

require __DIR__.'/../../vendor/autoload.php';

ob_start();

$manager = new CookieManager();

$manager->register( Cookie::create('cookie_1') );

$manager->register( SecureCookie::create('cookie_2',"thisismyverycomplexpassword") );

$result = $manager->load()->getValues();

ob_end_clean();

echo json_encode($result);