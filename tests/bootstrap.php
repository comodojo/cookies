<?php

// Simple bootloader for phpunit using composer autoloader

$loader = require __DIR__ . "/../vendor/autoload.php";
$loader->addPsr4('Comodojo\\Cookies\\Tests\\', __DIR__ . "/Comodojo/Cookies");
$loader->addPsr4('Comodojo\\Zip\\Tests\\Utils\\', __DIR__ . "/Comodojo/Cookies/Utils");