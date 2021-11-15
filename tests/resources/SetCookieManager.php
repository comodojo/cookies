<?php

use Comodojo\Cookies\Cookie;
use Comodojo\Cookies\SecureCookie;
use Comodojo\Cookies\CookieManager;
use Comodojo\Exception\CookieException;

require __DIR__.'/../../vendor/autoload.php';

ob_start();

$manager = new CookieManager();
$manager->add( Cookie::create('cookie_1',array('value'=>'cookie-1')) );
$manager->add( SecureCookie::create('cookie_2',"thisismyverycomplexpassword",array('value'=>'cookie-2')) );
$result = $manager->save();

ob_end_clean();
echo json_encode(array("manager"=>$result));