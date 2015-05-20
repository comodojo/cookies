<?php

use Comodojo\Cookies\Cookie;
use Comodojo\Cookies\SecureCookie;
use Comodojo\Cookies\CookieManager;
use Comodojo\Exception\CookieException;

require __DIR__.'/../../vendor/autoload.php';

ob_start();

$manager = new CookieManager();

$manager->register( Cookie::create('cookie_1',array('value'=>'cookie-1')) );

$manager->register( SecureCookie::create('cookie_2',"thisismyverycomplexpassword",array('value'=>'cookie-2')) );

$result = $manager->save();

ob_end_clean();

echo json_encode(array("manager"=>$result));