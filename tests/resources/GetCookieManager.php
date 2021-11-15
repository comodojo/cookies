<?php

use Comodojo\Cookies\Cookie;
use Comodojo\Cookies\SecureCookie;
use Comodojo\Cookies\CookieManager;

require __DIR__.'/../../vendor/autoload.php';

ob_start();

$manager = new CookieManager();
$manager->add( Cookie::create('cookie_1') );
$manager->add( SecureCookie::create('cookie_2',"thisismyverycomplexpassword") );
$result = $manager->load()->getValues();

ob_end_clean();

echo json_encode($result);